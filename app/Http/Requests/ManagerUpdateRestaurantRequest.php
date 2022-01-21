<?php

namespace App\Http\Requests;

use App\Constants\Roles;
use App\Constants\Themes;
use App\Constants\ValidationStrings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ManagerUpdateRestaurantRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'user_email' => 'email',
            'notes1' => 'nullable',
            'notes2' => 'nullable',
            'is_logo_active' => 'nullable',
            
            'description' => 'required|string|min:4|max:400',

            'logo' => ValidationStrings::IMAGE_VALIDATION,
            'current_theme' => [
                'required',
                'integer',
                'in:' . implode(',', Themes::AVAILABLE_THEMES),
                function ($attribute, $value, $fail) {
                    if (!auth()->user() && auth()->user()->restaurant && auth()->user()->restaurant->isThemeAvailable($value)) {
                        $fail(':attribute is not available for you');
                    }
                }
            ],
            'open_from' => 'nullable|date_format:H:i',
            'open_to' => 'nullable|date_format:H:i',
            'phone' => 'nullable|numeric',
            'whatsapp_number' => 'nullable|numeric',
            'google_map_location_link' => 'nullable|string:url',
            'facebook_link' => 'nullable|string:url',
            'twitter_link' => 'nullable|string:url',
            'instagram_link' => 'nullable|string:url',
            'snapchat_link' => 'nullable|string:url',
            'main_theme_color_code' => ['nullable', ValidationStrings::COLOR_CODE],
            'back_theme_select' => 'required',
            'back_image_hide_val' => 'nullable'
            
        ];
    }
}
