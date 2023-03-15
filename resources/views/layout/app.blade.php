<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>CRM Admin | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/dist/img/mini-logo.png') }}" type="image/x-icon">
    <link href="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/lobipanel/lobipanel.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/pace/flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/themify-icons/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/emojionearea/emojionearea.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/monthly/monthly.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/dist/css/stylecrm.css') }}" rel="stylesheet" type="text/css" />
    <link href="http://lasik.tarule.in/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
        rel="stylesheet">
        @livewireStyles

</head>

<body class="sidebar-mini  pace-done sidebar-collapse">
    <!-- <div id="preloader">
         <div id="status"></div>
      </div>  -->
    <div class="wrapper">
        <header class="main-header">
            <a href="/dashboard" class="logo">
                <span class="logo-mini">
                    <img src="assets/dist/img/mini-logo.png" alt="">
                </span>
                <span class="logo-lg">
                    <img src="assets/dist/img/logo.png" alt="">
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
                                <img src="assets/dist/img/avatar5.png" class="img-circle" width="45" height="45"
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
        <aside class="main-sidebar">
            <div class="sidebar">
                <ul class="sidebar-menu">
                    <li class="active">
                        <a href="/"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                            <span class="pull-right-container">
                            </span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i><span>Master</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/master">Create Master</a></li>
                            @livewire('dynamics')
                            <li><a href="/state">State</a></li>
                            <li><a href="/city">City</a></li>
                            <li><a href="location.php">Location</a></li>
                            <li><a href="CentreDetails.php">Center Details</a></li>
                            <li><a href="Leadandcenterassigning.php">Lead & Center Assigning Rules</a></li>
                            <li><a href="ruleandregulation.php">Rules & Regulations</a></li>
                            <li><a href="lead-conditions.php">Lead Conditions</a></li>
                            <li><a href="TemplateMaster.php">Template Master</a></li>
                            <li><a href="AddMenu.php">Add Menu</a></li>
                            <li><a href="Submenu.php">Sub Menu</a></li>
                            <li><a href="SocialIntegration.php">Social Integration</a></li>
                            <li><a href="/designation">Create Designation</a></li>
                            <li><a href="Grant_authority.php">Permission</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-basket"></i><span>Employee Managment</span>

                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/employee">Employee Details</a></li>
                            <li><a href="/leave">Employee Leaves</a></li>
                            <!-- <li><a href="Employee_authority.php">Employee Permissions</a></li> -->
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-sliders"></i><span>Roles & Permission</span>

                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/role">Roles</a></li>
                            <li><a href="/permission">Permissions</a></li>
                            <!-- <li><a href="Employee_authority.php">Employee Permissions</a></li> -->
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-cart"></i><span>Lead Management</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/leadstatus">Add/Edit Lead </a></li>
                            <li><a href="/leadcalls">First Calling</a></li>
                            <li><a href="/leadassignment">Lead Follow Up</a></li>
                            <li><a href="/leadstatus">Master Data</a></li>
                            <li><a href="/leadupload">Upload Data</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="logReport.php">
                            <i class="fa fa-book"></i><span>Log Report</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="SMS-Email-WhatsApp-send.php">
                            <i class="fa fa-book"></i><span>SMS/Email/WhatsApp Send</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text"></i><span>Other Management</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="HelpQuesAns.php">Lasik Blogs</a></li>
                            <li><a href="DailyQuotes.php">Daily Quotes</a></li>
                            <li><a href="OccasionDetails.php">Occasion Details</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </aside>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-dashboard"></i>
                </div>
                <div class="header-title">
                    <h1>@yield('title')</h1>
                    <small>@yield('subtitle')</small>
                </div>
            </section>
            <section class="content">
                @yield('content')
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
    <script src="http://lasik.tarule.in/js/dataTables.bootstrap.min.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/samples/js/sample.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/styles.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("Comments", {
            height: 200
        });
        CKEDITOR.replace("Comments2", {
            height: 200
        });
    </script>
    <script>
        function dash() {
            var ctx = document.getElementById("singelBarChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Nobemver", "December"],
                    datasets: [{
                        label: "Count",
                        data: [12, 5],
                        borderColor: "rgba(0, 150, 136, 0.8)",
                        width: "1",
                        borderWidth: "0",
                        backgroundColor: "rgba(0, 150, 136, 0.8)"
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            //monthly calender
            $('#m_calendar').monthly({
                mode: 'event',
                //jsonUrl: 'events.json',
                //dataType: 'json'
                xmlUrl: 'events.xml'
            });

            //bar chart
            var ctx = document.getElementById("barChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "august", "september",
                        "october", "Nobemver", "December"
                    ],
                    datasets: [{
                            label: "My First dataset",
                            data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
                            borderColor: "rgba(0, 150, 136, 0.8)",
                            width: "1",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 150, 136, 0.8)"
                        },
                        {
                            label: "My Second dataset",
                            data: [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86],
                            borderColor: "rgba(51, 51, 51, 0.55)",
                            width: "1",
                            borderWidth: "0",
                            backgroundColor: "rgba(51, 51, 51, 0.55)"
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            //counter
            $('.count-number').counterUp({
                delay: 10,
                time: 5000
            });
        }
        dash();
    </script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                aLengthMenu: [
                    [50, 100, 200, 500, -1],
                    [50, 100, 200, 500, "All"]
                ],
                'iDisplayLength': 100,
                scrollX: true,
                responsive: true,
                "scrollY": 400,
                "scrollCollapse": true,
                fixedColumns: {
                    leftColumns: 4
                }
            });
        });
    </script>
</body>

</html>
