<?php

namespace App\Http\Requests;

use App\Constants\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole(Roles::ADMIN_ROLE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'email' => [
                'required',
                'unique:users,email,' . $this->id
            ],
            'password' => 'required|min:6'
        ];
    }
}
