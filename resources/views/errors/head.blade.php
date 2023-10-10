<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <link href="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/lobipanel/lobipanel.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/pace/flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/themify-icons/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/emojionearea/emojionearea.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/monthly/monthly.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dist/css/stylecrm.css') }}" rel="stylesheet" type="text/css" />    
    <link href="http://lasik.tarule.in/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet" />
    @livewireStyles
</head>