<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

    public function index(Request $request){


        $orders = new Order();
        // validate start and end date in filter search order date
        if($request->start_date){
            $orders = $orders->where('created_at', '>=' , $request->start_date);
        }
        if($request->end_date){
            $orders = $orders->where('created_at', '<=' , $request->end_date);
        }
        // sum all total
        $orders = $orders->with(['order_items','payments','customer'])->orderBy('id','desc')->paginate(10);
        $total= $orders->map(function($i){
            return $i->total();
        })->sum();
        // sum all amount
        $recieve = $orders->map(function($r){
            return $r->recieve();
        })->sum();
        return view('layouts.order.index',compact('orders','total','recieve'));
    }

    public function store(OrderStoreRequest $request){

            $orders = Order::create([
            'user_id'       =>$request->user()->id,
            'customer_id'   =>$request->customer_id
        ]);
        $cart = $request->user()->cart()->get();
       foreach($cart as $item){
            $orders->order_items()->create([
                'price'         =>$item->price,
                'quantity'      =>$item->pivot->quantity,
                'product_id'    =>$item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
       }
        //    clear item from cart
     $request->user()->cart()->detach();

       $orders->payments()->create([
            'amount'    =>$request->amount,
            'user_id'   =>$request->user()->id,
       ]);
       return "succes";

    }
}
