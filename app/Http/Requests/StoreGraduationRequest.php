<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Graduation;
use Illuminate\Foundation\Http\FormRequest;

class StoreGraduationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Graduation::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'ceremony_date' => ['required', 'date', 'after:today'],
            'fee' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'status' => ['required', 'in:draft,open,closed'],
        ];
    }
}
