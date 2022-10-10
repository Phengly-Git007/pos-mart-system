@extends('layouts.partials.master')
@section('title')
    Customer
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('customers.update',$customer) }}" method="POST" enctype="multipart/form-data" role="form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name',$customer->first_name) }}" class="form-control @error('first_name') is-invalid @enderror " placeholder=" first_name"  autofocus autocomplete="off">
                        @error('first_name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name',$customer->last_name) }}" class="form-control  @error('last_name') is-invalid @enderror " placeholder="last_name"  autocomplete="off">
                            @error('last_name')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="avatar"> Avatar</label>
                        <input type="file" name="avatar" id="avatar" value="{{ old('avatar',$customer->avatar) }}" class="form-control @error('avatar') is-invalid @enderror ">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email',$customer->email) }}" class="form-control  @error('email') is-invalid @enderror " placeholder="email"  autocomplete="off">
                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" id="phone" value="{{ old('phone',$customer->phone) }}" class="form-control  @error('phone') is-invalid @enderror " placeholder="phone"  autocomplete="off">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address',$customer->address) }}" class="form-control  @error('address') is-invalid @enderror " placeholder="address"  autocomplete="off">
                            @error('address')
                                <div class="invalid-feedback" role="alert">
                                   <strong> {{ $message }}</strong>
                                </div>
                            @enderror
                    </div>


                    <button class="btn btn-primary btn-sm" type="submit">Update Customer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
