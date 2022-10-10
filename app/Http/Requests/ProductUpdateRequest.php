<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $product_id = $this->route('product')->id;
        return [
            'name'          =>['required'],
            'image'         =>['nullable'],
            'price'         =>['required'],
            'quantity'      =>['required'],
            'barcode'       =>['required','unique:products,barcode,' .$product_id],
            'description'   =>['nullable'],
            'status'        =>['required','boolean']
        ];
    }
}
