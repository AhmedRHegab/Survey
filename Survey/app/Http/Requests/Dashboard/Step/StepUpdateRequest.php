<?php

namespace App\Http\Requests\Dashboard\Step;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StepUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() :bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() :array
    {
        return [
            'name'      => ['required', Rule::unique('steps', 'name')->ignore($this->step)],
            'status'    => ['required', 'boolean']
        ];
    }
}
