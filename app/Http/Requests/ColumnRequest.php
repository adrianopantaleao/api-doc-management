<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ColumnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => Str::lower($this->name),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('columns', 'name')->ignore($this->id)
            ],
            'active' => 'boolean',
            'type_id' => 'required|exists:App\Models\Type,id',
        ];
    }
}
