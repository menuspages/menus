<?php

namespace App\Http\Requests;

use App\Constants\Order;
use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
            'items' => ['required', function ($attribute, $value, $fail) {
                try {
                    if (is_array(json_decode($value, true)) && count(json_decode($value, true)) >= 1) {
                        foreach (json_decode($value, true) as $item) {
                            if (!(isset($item['id']) && isset($item['quantity']) && isset($item['price']) && $item['id'] && $item['quantity'] >= 1)) {
                                throw new \Exception('خطأ في نوع المنتج او الكمية');
                            }
                        }
                    } else {
                        throw new \Exception('خطأ في نوع المنتج او الكمية');
                    }
                } catch (\Exception $exception) {
                    $fail($exception->getMessage());

                }
            }],
            'name' => 'required|string|min:2',
            'phone' => 'required|numeric|min:2',
            'address' => 'nullable|string|min:2',
            'location' => 'nullable|string',
            'transfer_type' => 'nullable',
            'transfer_type_recp' => 'nullable',
            'date' => 'nullable',
            'note' => 'nullable',
            'allergens' => 'nullable',
            'notes' => 'nullable|string|min:2',
            'pickup_type' => 'required|in:' . implode(',' , array_keys(Order::PICKUP_TYPES))
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'من فضلك ادخل الاسم صحيح',
            'name.required' => 'من فضلك ادخل الاسم صحيح',
            'phone.required' => 'من فضلك ادخل رقم الهاتف',
            'phone.numeric' => 'من فضلك ادخل رقم الهاتف صحيح من ارقام',
            'address.required' => 'من فضلك ادخل العنوان',
            'address.min' => 'من فضلك ادخل العنوان',
            'pickup_type.required' => 'من فضلك ادخل نوع الاستلام توصيل او استلام من المطعم'
        ];
    }
}
