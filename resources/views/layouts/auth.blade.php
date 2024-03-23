<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
       <!-- Title -->
       <title>{{ config('app.name', 'To Do List') }}</title>
       <!--to make http ajax request to https-->
       <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    @vite(['resources/sass/admin.scss'])

</head>
<style>
    .collapse-item-long {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
</style>

<body style="background-color: #c1d82f">
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-md-5">
            <div class="card o-hidden border-3px shadow-lg my-5" style=" border-radius: 10px;">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    @yield('content')
                </div>
            </div>
        </div>

    </div>

</div>


<!-- Scripts -->
@vite(['resources/js/admin.js'])
<script src="{{ url('js/add_more.js') }}"></script>
@stack('scripts')

</body>

</html>









