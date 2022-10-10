@extends('layouts.partials.master')
@section('title')
    Order List
@endsection

@section('header')
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-8">
        <form action="{{ route('orders.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <input type="datetime-local" class="form-control form-control-sm" name="start_date"  value="{{ request('start_date') }}" >
                </div>
                <div class="col-md-5">
                    <input type="datetime-local" class="form-control form-control-sm" name="end_date" value="{{ request('end_date') }} " >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('action')
    <a href="{{ route('cart.index') }}" class="btn btn-primary ">Open POS</a>
@endsection

@section('content')
    <div class="card">

        <div class="card-body">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Total</th>
                    <th>Recieve</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Created</th>
                    {{-- <th>Action</th> --}}
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->getCustomerName() }}</td>
                            <td>
                                <img src="{{ Storage::url($order->getCustomerImage()) }}"  width="50px" height="50px" alt="Null">
                            </td>
                            <td>{{ config('settings.currency_symbol') }} {{ $order->formatTotal() }}</td>
                            <td>{{ config('settings.currency_symbol') }} {{ $order->formatRecieve() }}</td>
                            <td>
                                @if ($order->recieve() == 0)
                                    <span class="badge badge-danger">No Paid</span>
                                @elseif ($order->recieve() < $order->total())
                                    <span class="badge badge-warning">Partials</span>
                                @elseif ($order->recieve() == $order->total())
                                    <span class="badge badge-primary">Full Paid</span>
                                @else
                                <span class="badge badge-success">Changes</span>
                                @endif
                            </td>
                            <td>{{ config('settings.currency_symbol') }} {{number_format( $order->total() - $order->recieve(),2)}}</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{-- <tr> --}}
                        <th></th>
                        <th></th>
                        <th>{{ config('settings.currency_symbol') }} {{ number_format($total,2) }}</th>
                        <th>{{ config('settings.currency_symbol') }} {{ number_format($recieve,2) }}</th>

                    {{-- </tr> --}}
                </tfoot>
            </table>
            <br>
            {{ $orders->render() }}
        </div>
    </div>
@endsection
