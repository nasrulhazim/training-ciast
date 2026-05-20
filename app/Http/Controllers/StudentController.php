<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Graduation;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

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

        return redirect()
            ->route('graduations.students.show', [$graduation, $student])
            ->with('status', 'Payment verified.');
    }

    public function destroy(Graduation $graduation, Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);

        $student->delete();

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', 'Student removed.');
    }
}
