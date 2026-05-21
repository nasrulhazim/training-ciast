<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BulkStudentActionRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Audit;
use App\Models\Graduation;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\SimpleExcel\SimpleExcelReader;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth')];
    }

    public function create(Graduation $graduation): View
    {
        $this->authorize('create', Student::class);

        return view('students.create', compact('graduation'));
    }

    public function store(StoreStudentRequest $request, Graduation $graduation): RedirectResponse
    {
        $student = $graduation->students()->create($request->validated());

        Audit::record('created', $student);

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', "Added {$student->name}.");
    }

    public function show(Graduation $graduation, Student $student): View
    {
        $this->authorize('view', $student);

        return view('students.show', compact('graduation', 'student'));
    }

    public function edit(Graduation $graduation, Student $student): View
    {
        $this->authorize('update', $student);

        return view('students.edit', compact('graduation', 'student'));
    }

    public function update(
        UpdateStudentRequest $request,
        Graduation $graduation,
        Student $student
    ): RedirectResponse {
        $data = $request->validated();

        if ($request->hasFile('payment_receipt')) {
            $data['payment_receipt'] = $request->file('payment_receipt')
                ->store('receipts', 'public');
            $data['paid_at'] = now();
        }

        $student->update($data);

        return redirect()
            ->route('graduations.students.show', [$graduation, $student])
            ->with('status', 'Student details updated.');
    }

    public function verify(Graduation $graduation, Student $student): RedirectResponse
    {
        $this->authorize('verify', $student);

        $student->update(['verified_at' => now()]);

        Audit::record('verified', $student);

        return redirect()
            ->route('graduations.students.show', [$graduation, $student])
            ->with('status', 'Payment verified.');
    }

    public function destroy(Graduation $graduation, Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);

        Audit::record('deleted', $student, [
            'name' => $student->name,
            'ic' => $student->ic,
        ]);

        $student->delete();

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', 'Student removed.');
    }

    public function bulk(BulkStudentActionRequest $request, Graduation $graduation): RedirectResponse
    {
        $ids = $request->validated()['ids'];
        $action = $request->validated()['action'];

        $scope = $graduation->students()->whereIn('uuid', $ids);

        if ($action === 'verify') {
            $toVerify = (clone $scope)->whereNotNull('payment_receipt')->get();
            $skipped = (clone $scope)->whereNull('payment_receipt')->count();

            foreach ($toVerify as $student) {
                $student->update(['verified_at' => now()]);
                Audit::record('verified', $student, ['via' => 'bulk']);
            }

            return redirect()
                ->route('graduations.show', $graduation)
                ->with('status', "Verified {$toVerify->count()}. Skipped {$skipped} (no receipt).");
        }

        $rows = (clone $scope)->get();
        foreach ($rows as $student) {
            Audit::record('deleted', $student, [
                'via' => 'bulk',
                'name' => $student->name,
                'ic' => $student->ic,
            ]);
        }
        $scope->delete();

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', "Removed {$rows->count()}.");
    }

    public function export(Request $request, Graduation $graduation): StreamedResponse
    {
        $this->authorize('viewAny', Student::class);

        $query = $graduation->students()
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->string('search')->trim() . '%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('name', 'like', $term)
                        ->orWhere('ic', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('matric_card', 'like', $term);
                });
            })
            ->when($request->status === 'verified',
                fn ($q) => $q->whereNotNull('verified_at'))
            ->when($request->status === 'pending',
                fn ($q) => $q->whereNotNull('paid_at')->whereNull('verified_at'))
            ->when($request->status === 'not_paid',
                fn ($q) => $q->whereNull('paid_at'));

        $filename = Str::slug($graduation->title) . '-students-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['name', 'ic', 'email', 'matric_card', 'phone', 'paid_at', 'verified_at']);

            $query->lazy()->each(function (Student $student) use ($out) {
                fputcsv($out, [
                    $student->name,
                    $student->ic,
                    $student->email,
                    $student->matric_card,
                    $student->phone,
                    $student->paid_at?->toIso8601String(),
                    $student->verified_at?->toIso8601String(),
                ]);
            });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function import(Request $request, Graduation $graduation): RedirectResponse
    {
        $this->authorize('create', Student::class);

        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $imported = 0;
        $skipped = 0;

        SimpleExcelReader::create($request->file('csv')->getRealPath(), 'csv')
            ->getRows()
            ->each(function (array $row) use ($graduation, &$imported, &$skipped) {
                $validator = Validator::make($row, [
                    'name' => ['required', 'string', 'max:255'],
                    'ic' => ['required', 'string', 'size:12', 'unique:students,ic'],
                    'email' => ['required', 'email', 'unique:students,email'],
                    'matric_card' => ['required', 'string', 'max:100'],
                    'phone' => ['required', 'string', 'max:20'],
                ]);

                if ($validator->fails()) {
                    $skipped++;

                    return;
                }

                $graduation->students()->create($validator->validated());
                $imported++;
            });

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', "Imported {$imported}. Skipped {$skipped}.");
    }
}
