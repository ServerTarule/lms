<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dist/css/stylecrm.css') }}" rel="stylesheet" type="text/css" />    
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets/errors/error.css') }}" rel="stylesheet" type="text/css" />

    @livewireStyles
<style>
    </style>
</head>
<body class="pace-done sidebar-collapse">
    <div class="wrapper">
        {{-- @include('errors.header') --}}
        <div class="centered d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Not Found .</p>
                <p class="lead">
                    Page Your Are Looking For Is Not Found.
                </p>
                <p class="lead">
                    <a href="/" class="btn btn-sm btn-success">
                        <i class="fa fa-home fa-2x" style="color:white;"> <span style="font-family:ui-rounded;">Home</span></i>
                    </a>
                    <a onclick="window.history.back()" class="btn btn-sm btn-danger">
                        <i class='fa fa-arrow-circle-left fa-2x' style="color:white;"> <span  style="font-family:ui-rounded;">Back</span></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
