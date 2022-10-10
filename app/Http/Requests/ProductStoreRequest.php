<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'          =>['required'],
            'image'         =>['nullable'],
            'price'         =>['required'],
            'quantity'      =>['required'],
            'barcode'       =>['required','unique:products'],
            'description'   =>['nullable'],
            'status'        =>['required','boolean']
        ];
    }
}
