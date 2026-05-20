<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('student'));
    }

    public function rules(): array
    {
        $studentId = $this->route('student')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'ic' => [
                'required', 'string', 'size:12',
                Rule::unique('students', 'ic')->ignore($studentId),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('students', 'email')->ignore($studentId),
            ],
            'matric_card' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'payment_receipt' => [
                'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048',
            ],
        ];
    }
}
