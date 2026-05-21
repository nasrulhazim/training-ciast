<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Student::class);
    }

    public function rules(): array
    {
        $gradId = $this->route('graduation')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'ic' => [
                'required', 'string', 'size:12',
                Rule::unique('students', 'ic')->where(fn ($q) => $q->where('graduation_id', $gradId)),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('students', 'email')->where(fn ($q) => $q->where('graduation_id', $gradId)),
            ],
            'matric_card' => [
                'required', 'string', 'max:100',
                Rule::unique('students', 'matric_card')->where(fn ($q) => $q->where('graduation_id', $gradId)),
            ],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }
}
