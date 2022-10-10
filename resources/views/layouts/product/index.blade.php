@extends('layouts.partials.master')
@section('title')
    Product
@endsection
@section('header')
    <a class="btn btn-outline-primary btn-sm" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bar"></i></a>
@endsection

@section('action')
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">New Product</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('backend/plugins/sweetalert2/sweetalert2.min.css')}}">
@endsection
@section('content')
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Barcode</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <img src="{{ Storage::url($product->image) }}" width="50px" height="50px" alt="">
                                </td>
                                <td>{{ $product->barcode }}</td>
                                <td>{{number_format( $product->quantity ,0)}}</td>
                                {{-- <td>
                                    <span class="right badge badge-{{$product->quantity ? 'success' : 'danger'}}">
                                      {{$product->quantity ? $product->quantity.' In Stock' : 'Out Of Stock'}}
                                </span> --}}
                                <td>{{ $product->price }}</td>
                                <td>
                                    <span class="right badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                        {{ $product->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $product->created_at }}</td>
                                <td>{{ $product->updated_at }}</td>
                                <td>
                                    <a href="{{ route('products.edit',$product) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('products.show',$product) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <button class="btn-delete btn btn-danger btn-sm" data-url="{{ route('products.destroy',$product) }}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{ $products->render() }}
            </div>
        </div>
@endsection
@section('js')
    <script src="{{asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
         $(document).ready(function () {
        $(document).on('click', '.btn-delete', function () {
            $this = $(this);
            Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            $.post($this.data('url'), {_method: 'DELETE', _token: '{{csrf_token()}}'}, function (res) {
                   $this.closest('tr').fadeOut(500, function () {
                       $(this).remove();
                   })
               })
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                    )
                }
            })
        })
    })
     </script>
@endsection
