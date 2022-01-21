<?php

namespace App\Http\Requests;

use App\Constants\ValidationStrings;
use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "restaurant_name" => 'required|string',
            "subdomain" => 'required|unique:restaurants,subdomain|' . ValidationStrings::SUBDOMAIN,
            "full_name" => 'required|string',
            "phone" => 'required|' . ValidationStrings::PHONE,
            "email" => 'required|email',
            "discount_code" => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            "restaurant_name.required" => 'من فضلك ادخل اسم المتجر صحيح',
            "subdomain.unique" => 'هذا النطاق موجود بالفعل، من فضلك اختر نطاق اخر',
            "subdomain.regex" => 'هذا النطاق صيغته غير صحيحة، من فضلك تأكد من وجود احرف انجليزية و ارقام و شرطة فقط',
            "full_name.required" => 'من فضلك ادخل الاسم صحيح',
            "phone.*" => 'من فضلك ادخل رقم هاتف صحيح',
            "email.*" => 'من فضلك ادخل ايميل صحيح',
            "discount_code.*" => 'من فضلك ادخل كود صحيح',
        ];
    }
}
