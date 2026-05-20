<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGraduationRequest;
use App\Http\Requests\UpdateGraduationRequest;
use App\Models\Graduation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class GraduationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('can:viewAny,App\\Models\\Graduation', only: ['index']),
        ];
    }

    public function index(): View
    {
        $graduations = Graduation::query()
            ->withCount('students')
            ->latest()
            ->paginate(15);

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

    public function show(Graduation $graduation): View
    {
        $this->authorize('view', $graduation);
        $graduation->load('students');

        return view('graduations.show', compact('graduation'));
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
