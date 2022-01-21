<?php

namespace App\Http\Requests;

use App\Constants\Roles;
use App\Constants\ValidationStrings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateItemRequest extends FormRequest
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
        $quantity_summary = $this->get("input_quantity_summary");
        $validationInputTargetQuantity = "";
        $validationInputTotalQuantity = "";
        
        if($quantity_summary ==1)
        {
            $validationInputTotalQuantity = "required|numeric";
            $validationInputTargetQuantity = "required|numeric"; 
            if($this->get("input_total_quantity") <= $this->get("input_target_quantity"))
            {
                $validationInputTotalQuantity = [
                    'required',
                    function ($attribute, $value, $fail) {
                            $fail('total quantity cannot be less than target quantity');
                    }];
            }

        }
        return [
            'input_target_quantity' => $validationInputTargetQuantity,
            'input_total_quantity' => $validationInputTotalQuantity,

            'name' => 'required|string|min:2|max:50',
            'description' => 'nullable|string|min:2',
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, auth()->user()->restaurant->categories()->pluck('id')->toArray())) {
                        $fail('هذا الصنف غير تابع للمطعم');
                    }
                }],
            'current_price' => 'required|numeric',
            'calories' => 'nullable|numeric',
            'old_price' => 'nullable|numeric',
            'is_visible' => 'required|boolean',
            'is_available' => 'required|boolean',
            'image' => ValidationStrings::IMAGE_VALIDATION,
        ];
    }
}
