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
        $student = $this->route('student');
        $gradId = $student?->graduation_id;
        $studentId = $student?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'ic' => [
                'required', 'string', 'size:12',
                Rule::unique('students', 'ic')
                    ->where(fn ($q) => $q->where('graduation_id', $gradId))
                    ->ignore($studentId),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('students', 'email')
                    ->where(fn ($q) => $q->where('graduation_id', $gradId))
                    ->ignore($studentId),
            ],
            'matric_card' => [
                'required', 'string', 'max:100',
                Rule::unique('students', 'matric_card')
                    ->where(fn ($q) => $q->where('graduation_id', $gradId))
                    ->ignore($studentId),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'payment_receipt' => [
                'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048',
            ],
        ];
    }
}
