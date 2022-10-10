<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerstoreRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        if($request->wantsJson()){
            return response(
                Customer::all()
            );
        }
        $customers = Customer::orderBy('id','desc')->paginate(10);
        return view('layouts.customer.index',compact('customers'));
    }

    public function create()
    {
        return view('layouts.customer.create');
    }

    public function store(CustomerstoreRequest $request)
    {
        $avatar_path = '';
        if($request->hasFile('avatar')){
            $avatar_path = $request->file('avatar')->store('public/customers');
        }
        $customer = Customer::create([
            'first_name'    =>$request->first_name,
            'last_name'     =>$request->last_name,
            'email'         =>$request->email,
            'phone'         =>$request->phone,
            'address'       =>$request->address,
            'user_id'       =>$request->user()->id,
            'avatar'        =>$avatar_path
        ]);
        if(!$customer){
            return redirect()->back()->with('error' ,'Customer Create Failed !');
        }
        return redirect()->route('customers.index')->with('success','Customer Created Successfully !');
    }

    public function show($id)
    {
        //
    }

    public function edit(Customer $customer)
    {
        return view('layouts.customer.edit',compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->first_name        = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email       = $request->email;
        $customer->phone    = $request->phone;
        $customer->address     = $request->address;
          if($request->hasFile('avatar')){
              // delete
              Storage::delete($customer->avatar);
              // store
              $avatar_path = $request->file('avatar')->store('public/customers');
              // save
              $customer->avatar = $avatar_path;
          }
          if(!$customer->save()){
              return redirect()->back()->with('error' ,'Customer Edit Failed !');
          }
          return redirect()->route('customers.index')->with('success','Customer Edit Successfully !');
    }

    public function destroy(Customer $customer)
    {
        Storage::delete($customer->avatar);
        $customer->delete();
        return view('layouts.customer.index');
    }
}
