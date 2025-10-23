<?php

namespace App\Http\Requests\Dashboard\Survey;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SurveyStoreRequest extends FormRequest
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
            'step'          => ['required', Rule::exists('steps', 'id')],
            'group'         => ['required', Rule::exists('groups', 'id')],
            'questions.0'   => ['required' , Rule::exists('questions', 'id')],
            'questions.*'   => ['required' , Rule::exists('questions', 'id')],
            'attachments'   =>  [
                                'sometimes',
                                'nullable',
                                'image',
                                'mimes:' . config('setting.image.allow_extensions'),
                                'max:' . config('setting.image.size')
            ],

        ];
    }
}
