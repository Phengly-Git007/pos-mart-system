<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'          =>$this->id,
            'name'        =>$this->name,
            'image'       =>$this->image,
            'description' =>$this->description,
            'price'       =>$this->price,
            'quantity'    =>$this->quantity,
            'barcode'     =>$this->barcode,
            'status'      =>$this->status,
            'created_at'  =>$this->created_at,
            'image_url'   =>Storage::url($this->image)
        ];
    }
}
