<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = new Product();

        if($request->search){
            $products = $products->where('name', 'LIKE', "%{$request->search}%");
        }
        $products = $products->latest()->paginate(10);
        if($request->wantsJson()){

            return ProductResource::collection($products);
        }
        return view('layouts.product.index',compact('products'));
    }


    public function create()
    {
        return view('layouts.product.create');
    }

    public function store(ProductStoreRequest $request)
    {
        $image_path = '';
        if($request->hasFile('image')){
            $image_path = $request->file('image')->store('public/products');
        }
        $product = Product::create([
            'name'        =>$request->name,
            'price'       =>$request->price,
            'quantity'    =>$request->quantity,
            'description' =>$request->description,
            'barcode'     =>$request->barcode,
            'status'      =>$request->status,
            'image'       =>$image_path
        ]);
        if(!$product){
            return redirect()->back()->with('error' ,'Product Create Failed !');
        }
        return redirect()->route('products.index')->with('success','Product Created Successfully !');
    }

    public function show($id)
    {
        //
    }

    public function edit(Product $product)
    {
        return view('layouts.product.edit',compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
      $product->name        = $request->name;
      $product->description = $request->description;
      $product->price       = $request->price;
      $product->quantity    = $request->quantity;
      $product->barcode     = $request->barcode;
      $product->status      = $request->status;
        if($request->hasFile('image')){
            // delete
            Storage::delete($product->image);
            // store
            $image_path = $request->file('image')->store('public/products');
            // save
            $product->image = $image_path;
        }
        if(!$product->save()){
            return redirect()->back()->with('error' ,'Product Edit Failed !');
        }
        return redirect()->route('products.index')->with('success','Product Edit Successfully !');
    }

    public function destroy(Product $product)
    {
        // delete file from storage
        Storage::delete($product->image);
        $product->delete();
        return view('layouts.product.index');
    }
}
