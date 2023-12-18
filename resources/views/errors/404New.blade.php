<!DOCTYPE html>
<html lang="en">
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
<body class="sidebar-mini  pace-done sidebar-collapse">
    <div class="wrapper">
        <header class="main-header">
            <a href="/dashboard" class="logo">
                <span class="logo-mini">
                    <img src="{{ asset('assets/dist/img/mini-logo.png') }}" alt="">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/dist/img/logo.png') }}" alt="">
                </span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="pe-7s-angle-left-circle"></span>
                </a>
                <a href="#search"><span class="pe-7s-search"></span></a>
                <div id="search">
                    <button type="button" class="close">×</button>
                    <form>
                        <input type="search" value="" placeholder="Search.." />
                        <button type="submit" class="btn btn-add">Search...</button>
                    </form>
                </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown dropdown-help">
                            <a href="help.php" class="dropdown-toggle">
                                <i class="fa fa-question-circle-o"></i></a>
                        </li>
                        <!-- user -->
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('assets/dist/img/avatar5.png') }}" class="img-circle" width="45" height="45"
                                    alt="user"></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="profile.php">
                                        <i class="fa fa-user"></i> profile</a>
                                </li>
                                <li>
                                    <a href="changepassword.php">
                                        <i class="fa fa-lock"></i> Change Password</a>
                                </li>
                                <li><a href="/logout">
                                        <i class="fa fa-sign-out"></i> Signout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-dashboard"></i>
                </div>
                <div class="header-title">
                    <h1>Error</h1>
                    <small>403</small>
                </div>
            </section>
            <section class="content">
                {{-- @include('errors.404') --}}
            </section>
        </div>
    </div>
    @livewireScripts
    <script src="{{ asset('assets//plugins/jQuery/jquery-1.12.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/jquery-ui-1.12.1/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/lobipanel/lobipanel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/fastclick/fastclick.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//dist/js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/chartJs/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/counterup/waypoints.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//plugins/monthly/monthly.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets//dist/js/dashboard.js') }}" type="text/javascript"></script>
    <script src="http://lasik.tarule.in/js/jquery.dataTables.min.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/samples/js/sample.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/styles.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/ckeditor.js"></script>
</body>
</html>
