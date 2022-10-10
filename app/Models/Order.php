<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable =['customer_id','user_id'];

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    // display cust_name
    public function getCustomerName(){
        if($this->customer){
            return $this->customer->first_name .' '. $this->customer->last_name;
        }
        return "mystery";
    }
    public function getCustomerImage(){
        if($this->customer){
            return $this->customer->avatar;
        }
    }
// get total
    public function total(){
        return $this->order_items->map(function ($item){
            return $item->price;
        })->sum();
    }
// format total
    public function formatTotal(){
        return number_format($this->total(),2);
    }
    // get recieve amount
    public function recieve(){

        return $this->payments->map(function ($pay){
            return $pay->amount;
        })->sum();
    }
    // format recieve
    public function formatRecieve(){
        return number_format($this->recieve(),2);
    }
}
