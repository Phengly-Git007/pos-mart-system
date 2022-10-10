@extends('layouts.partials.master')
@section('title')
    customer
@endsection

@section('header')
    customer list
@endsection
@section('action')
    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">New Customer</a>
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
                    <th>Avatar</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>

                    <th>Created</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                            <td>
                                <img src="{{ Storage::url($customer->avatar) }}" width="50px" height="50px" alt="">
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->created_at }}</td>
                            <td>
                                <a href="{{ route('customers.edit',$customer) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                {{-- <a href="{{ route('customers.show',$customer) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> --}}
                                <button class="btn-delete btn btn-danger btn-sm" data-url="{{ route('customers.destroy',$customer) }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            {{ $customers->render() }}
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
