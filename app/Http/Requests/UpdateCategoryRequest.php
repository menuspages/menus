<?php

namespace App\Http\Requests;

use App\Constants\Roles;
use App\Constants\ValidationStrings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole(Roles::RESTAURANT_MANAGER_ROLE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:100',
            'image' => ValidationStrings::IMAGE_VALIDATION
        ];
    }
}
