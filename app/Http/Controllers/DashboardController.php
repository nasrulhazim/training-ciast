<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Graduation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $totals = [
            'graduations' => Graduation::count(),
            'students' => Student::count(),
            'verified' => Student::whereNotNull('verified_at')->count(),
            'pending' => Student::whereNotNull('paid_at')->whereNull('verified_at')->count(),
            'not_paid' => Student::whereNull('paid_at')->count(),
        ];

        $graduations = Graduation::query()
            ->withCount([
                'students',
                'students as verified_count' => fn ($q) => $q->whereNotNull('verified_at'),
                'students as pending_count' => fn ($q) => $q
                    ->whereNotNull('paid_at')
                    ->whereNull('verified_at'),
                'students as not_paid_count' => fn ($q) => $q->whereNull('paid_at'),
            ])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact('totals', 'graduations'));
    }
}
