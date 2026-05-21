<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGraduationRequest;
use App\Http\Requests\UpdateGraduationRequest;
use App\Models\Graduation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class GraduationController extends Controller implements HasMiddleware
{
    private const SORTABLE_COLUMNS = ['name', 'ic', 'email', 'matric_card', 'created_at'];

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('can:viewAny,App\\Models\\Graduation', only: ['index']),
        ];
    }

    public function index(Request $request): View
    {
        $graduations = Graduation::query()
            ->withCount('students')
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->string('search')->trim() . '%';
                $q->where('title', 'like', $term);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('graduations.index', compact('graduations'));
    }

    public function create(): View
    {
        $this->authorize('create', Graduation::class);

        return view('graduations.create');
    }

    public function store(StoreGraduationRequest $request): RedirectResponse
    {
        $graduation = Graduation::create($request->validated());

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', 'Graduation created.');
    }

    public function show(Graduation $graduation, Request $request): View
    {
        $this->authorize('view', $graduation);

        $sort = in_array($request->sort, self::SORTABLE_COLUMNS, true)
            ? $request->sort
            : 'created_at';

        $direction = $request->direction === 'asc' ? 'asc' : 'desc';

        $students = $graduation->students()
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
                fn ($q) => $q->whereNull('paid_at'))
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        return view('graduations.show', compact('graduation', 'students'));
    }

    public function edit(Graduation $graduation): View
    {
        $this->authorize('update', $graduation);

        return view('graduations.edit', compact('graduation'));
    }

    public function update(UpdateGraduationRequest $request, Graduation $graduation): RedirectResponse
    {
        $graduation->update($request->validated());

        return redirect()
            ->route('graduations.show', $graduation)
            ->with('status', 'Graduation updated.');
    }

    public function destroy(Graduation $graduation): RedirectResponse
    {
        $this->authorize('delete', $graduation);
        $graduation->delete();

        return redirect()
            ->route('graduations.index')
            ->with('status', 'Graduation archived.');
    }
}
