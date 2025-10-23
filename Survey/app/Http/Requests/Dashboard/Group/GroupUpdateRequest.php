<?php

namespace App\Http\Requests\Dashboard\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends FormRequest
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
            'number'      => ['required','regex:/^[0-9]+$/', Rule::unique('groups', 'number')
                ->ignore($this->group)
                ->where('step_id', $this->step)],
            'status'    => ['required', 'boolean'],
            'step'      => ['required', Rule::exists('steps', 'id')]

        ];
    }
}
