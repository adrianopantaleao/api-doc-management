<?php

namespace App\Rules;

use App\Models\Type;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ColumnsAvaliable implements ValidationRule
{
    public Type $type;

    public function __construct($id)
    {
        $this->type = Type::find($id);
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!in_array($value, $this->type->columns->pluck('id')->toArray())){
            $fail('The :attribute is invalid for the document type #'.$this->type->id.' - '.$this->type->name);
        }
    }
}
