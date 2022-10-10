@extends('layouts.partials.master')
@section('title')
    setting
@endsection
@section('header')
    Update Setting
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('settings.store') }}" method="POST">
            @csrf
                <div class="form-group">
                    <label for="app_name">App Name</label>
                    <input type="text" name="app_name" value="{{ old('app_name',config('settings.app_name')) }}" class="form-control @error('app_name') is-invalid @enderror" placeholder="app name">
                        @error('app_name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="app_description">App Description</label>
                    <textarea type="text" name="app_description"  class="form-control @error('app_description') is-invalid @enderror" placeholder="app description">

                        {{ old('app_description',config('settings.app_description')) }}
                    </textarea>
                    @error('app_description')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                </div>

                <div class="form-group">
                    <label for="currency_symbol">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="{{ old('currency_symbol',config('settings.currency_symbol')) }}" class="form-control @error('currency_symbol') is-invalid @enderror" placeholder="currency symbol">
                        @error('currency_symbol')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                </div>
                    <button type="submit" class="btn btn-primary btn-sm">Change Setting</button>

            </form>
        </div>
    </div>
@endsection
