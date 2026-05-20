<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Student::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'ic' => ['required', 'string', 'size:12', 'unique:students,ic'],
            'email' => ['required', 'email', 'unique:students,email'],
            'matric_card' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }
}
