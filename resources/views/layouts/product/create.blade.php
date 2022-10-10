@extends('layouts.partials.master')
@section('title')
    Product
@endsection


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror " placeholder="product name"  autofocus autocomplete="off">
                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" name="image" id="image" value="{{ old('image') }}" class="form-control @error('image') is-invalid @enderror ">
                    </div>
                    <div class="form-group">
                        <label for="barcode">Product Barcode</label>
                        <input type="text" name="barcode" id="barcode" class="form-control  @error('barcode') is-invalid @enderror " placeholder="barcode"  autocomplete="off">
                            @error('barcode')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control  @error('price') is-invalid @enderror " placeholder="price"  autocomplete="off">
                            @error('price')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Product Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control  @error('quantity') is-invalid @enderror " placeholder="quantity"  autocomplete="off">
                            @error('quantity')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="2" placeholder="descriptions"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Product Status</label>
                       <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status') === 1 ? 'selected' : '' }} >Active</option>
                            <option value="0" {{ old('status') === 0 ? 'selected' : '' }} >Inactive</option>
                       </select>
                       @error('status')
                          <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </div>
                       @enderror
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">Create Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
