
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
       <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
       <link rel="stylesheet" href="{{ asset('backend /dist/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @yield('css')
  <script>
    window.APP = @php
        echo json_encode([
            'currency_symbol' =>config('settings.currency_symbol'),
        ])
    @endphp
  </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed"">
<div class="wrapper">
    {{-- @include('layouts.partials.navbar') --}}
    @include('layouts.partials.sidebar')

    <div class="content-wrapper">
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h5>@yield('header')</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">@yield('action')</li>
                </ol>
            </div>
            </div>
        </div>
        </section>
        <div class="container">
            @yield('content')
        </div>
    </div>
    {{-- @include('layouts.partials.footer') --}}
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
