<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MyRegistrationsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $registrations = $request->user()->students()
            ->with('graduation')
            ->latest()
            ->get();

        return view('my-registrations', compact('registrations'));
    }
}
