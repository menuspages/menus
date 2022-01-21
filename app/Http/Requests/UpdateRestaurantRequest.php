<?php

namespace App\Http\Requests;

use App\Constants\AppSettings;
use App\Constants\Roles;
use App\Constants\Themes;
use App\Constants\ValidationStrings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRestaurantRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'description' => 'required|string|min:4|max:200',
            'subdomain' => [
                'required',
                Rule::unique('restaurants')->ignore($this->route('subdomain'), 'subdomain'),
                ValidationStrings::SUBDOMAIN,
                'not_in:' . implode(',', AppSettings::RESERVED_SUBDOMAINS)
            ],
            'logo' => ValidationStrings::IMAGE_VALIDATION,
            'enable_component' => 'required|int',
            'is_active' => 'required|boolean',
            'available_themes' => 'required|array|min:1|in:' . implode(',', Themes::AVAILABLE_THEMES)
        ];
    }
}
