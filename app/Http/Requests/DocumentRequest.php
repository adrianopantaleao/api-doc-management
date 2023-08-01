<?php

namespace App\Http\Requests;

use App\Rules\ColumnsAvaliable;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DocumentRequest extends BaseRequest
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
                Rule::unique('documents', 'name')->ignore($this->id)
            ],
            'active' => 'boolean',
            'type_id' => 'required|exists:App\Models\Type,id',
            'content' => 'array',
            'content.*.column_id' => ['integer', new ColumnsAvaliable($this->type_id)],
            'content.*.text' => 'min:5',
        ];
    }
}
