<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class BulkStudentActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Student::class);
    }

    public function rules(): array
    {
        return [
            'action' => ['required', 'in:verify,delete'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['uuid'],
        ];
    }
}
