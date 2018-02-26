<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'API Mauale') }}</title>

    <!-- Styles -->
    <link href="{{ asset('theme/components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/AdminLTE.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/skins/_all-skins.min.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
    <!-- Main header -->
@include('partials.header')
<!-- Main sidebar -->
    @include('partials.sidebar', ['data' => (!empty($data))?$data:[]])

    <div class="content-wrapper">
        <!-- Page header -->
    @include('partials.page-header')
    <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('theme/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('theme/components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('theme/js/adminlte.min.js') }}"></script>
<script src="{{ asset('theme/js/application.js') }}"></script>
</body>
</html>
