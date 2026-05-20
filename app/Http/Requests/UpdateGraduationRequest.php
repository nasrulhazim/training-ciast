<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGraduationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('graduation'));
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'ceremony_date' => ['required', 'date'],
            'fee' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'status' => ['required', 'in:draft,open,closed'],
        ];
    }
}
