<?php

namespace App\Http\Requests\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
           'name'               => ['required'],
           'email'              => ['required', Rule::unique('users', 'email')],
           'password'           => ['required', 'min:6' , 'max:12'],
           'password_confirm'   => ['required', 'same:password' , 'min:6', 'max:12'],
           'status'             => ['required', 'boolean'],
            'roles'              => ['required', Rule::exists('roles', 'id')]
        ];
    }
}
