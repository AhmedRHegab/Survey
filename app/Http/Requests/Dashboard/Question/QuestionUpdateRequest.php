<?php

namespace App\Http\Requests\Dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionUpdateRequest extends FormRequest
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
            'question'      => ['required', Rule::unique('questions', 'question')
                ->where('type', $this->type)->ignore($this->question)],
            'status'        => ['required', 'boolean'],
            'type'          => ['required', Rule::in(['general', 'building', 'safeSecurity'])],
            'inputType'     => ['required', Rule::in(['checkbox', 'radio'])]
        ];
    }
}
