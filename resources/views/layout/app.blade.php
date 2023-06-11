<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}" >

{{--    <title>CRM Admin | @yield('title')</title>--}}
{{--    <link rel="shortcut icon" href="{{ asset('assets/dist/img/mini-logo.png') }}" type="image/x-icon">--}}
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
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />--}}
    <link href="http://lasik.tarule.in/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet" />
    @livewireStyles

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>

{{--    <script>--}}

{{--        document.addEventListener('DOMContentLoaded', function() {--}}
{{--            var calendarEl = document.getElementById('calendar');--}}
{{--            var calendar = new FullCalendar.Calendar(calendarEl, {--}}
{{--                initialView: 'timeGridWeek',--}}
{{--                slotMinTime: '8:00:00',--}}
{{--                slotMaxTime: '19:00:00',--}}
{{--                events: @json($events),--}}
{{--            });--}}
{{--            calendar.render();--}}
{{--        });--}}

{{--    </script>--}}

</head>

<body class="sidebar-mini  pace-done sidebar-collapse">
    <!-- <div id="preloader">
         <div id="status"></div>
      </div>  -->
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
        <aside class="main-sidebar">
            <div class="sidebar">
                <ul class="sidebar-menu">
                    @livewire('menus')
                    {{--  <li class="active">
                        <a href="/"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                            <span class="pull-right-container">
                            </span>
                        </a>
                    </li>--}}
                    {{-- <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i><span>Menu</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/menu">Create Menu</a></li>

                        </ul>

                    </li>--}}
                     {{--<li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i><span>Master</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>--}}
                        <ul class="treeview-menu">
                            <li><a href="/master">Create Master</a></li>
                            @livewire('dynamics')
{{--                            <li><a href="/actions">Action Type</a></li>--}}
{{--                            <li><a href="/states">State</a></li>--}}
{{--                            <li><a href="/cities">City</a></li>--}}
{{--                            <li><a href="location.php">Location</a></li>--}}
{{--                            <li><a href="CentreDetails.php">Center Details</a></li>--}}
{{--                            <li><a href="/states">State</a></li>--}}
{{--                            <li><a href="/cities">City</a></li>--}}
                            <li><a href="/locations">Locations</a></li>
                            <li><a href="/doctors">Doctors</a></li>
                            <li><a href="/centers">Center Details</a></li>
{{--                            <li><a href="Leadandcenterassigning.php">Lead & Center Assigning Rules</a></li>--}}
{{--                            <li><a href="/rules">Rules & Regulations</a></li>--}}
{{--                            <li><a href="lead-conditions.php">Lead Conditions</a></li>--}}
                            <li><a href="/templates">Templates</a></li>
                            <li><a href="/holidays">Holidays</a></li>
{{--                            <li><a href="AddMenu.php">Add Menu</a></li>--}}
{{--                            <li><a href="Submenu.php">Sub Menu</a></li>--}}
{{--                            <li><a href="SocialIntegration.php">Social Integration</a></li>--}}
{{--                            <li><a href="/designation">Create Designation</a></li>--}}
{{--                            <li><a href="Grant_authority.php">Permission</a></li>--}}
                        </ul>
                    </li>
                    {{--  
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-basket"></i><span>Rules & Regulations</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/rules">Rules</a></li>
                        </ul>
                    </li>
                   
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-basket"></i><span>Employee Management</span>

                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/employee">Employee Details</a></li>
                            <li><a href="/leaves">Employee Leaves</a></li>
                            <li><a href="/employees/permissions">Employee Permissions</a></li>
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
                            <li><a href="/leads">Leads</a></li>
                            <li><a href="/leads/calls">First Calling</a></li>
                            <li><a href="/leads/followup">Lead Follow Up</a></li>
                            <li><a href="/leadstatus">Master Data</a></li>
                            <li><a href="/leadupload">Upload Data</a></li>
                        </ul>
                    </li>
                    <li class="preview">
                        <a href="/logs">
                            <i class="fa fa-book"></i><span>Log Report</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="/communications">
                            <i class="fa fa-book"></i><span>Email/WhatsApp Send</span>
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
                            <li><a href="/blogs">LASIK Blogs</a></li>
                            <li><a href="/quotes">Daily Quotes</a></li>
                            <li><a href="/occasions">Occasion Details</a></li>
                        </ul>
                    </li>
                    --}}
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
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>--}}
    <script src="http://lasik.tarule.in/js/jquery.dataTables.min.js"></script>
    <script src="http://lasik.tarule.in/js/dataTables.bootstrap.min.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/samples/js/sample.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/styles.js"></script>
    <script src="http://lasik.tarule.in/ckeditor/ckeditor.js"></script>
{{--    <script src="{{ asset('assets//plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>--}}
{{--    <script src="{{ asset('assets//plugins/fullcalendar/lib/moment.min.js') }}" type="text/javascript"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
        $(document).ready(function() {
            toastr.options.timeOut = 1500; // 1.5s
            toastr.options.debug=false;
            toastr.options.positionClass="toast-top-right";
            toastr.options.onclick=null;
            toastr.options.fadeIn=300;
            toastr.options.fadeOut=1000;
            toastr.options.extendedTimeOut=1000
            {{--$('#day').datepicker({--}}
            {{--    format: '{{ config('app.date_format_javascript') }}',--}}
            {{--    locale: 'en'--}}
            {{--});--}}

            // $('.table').DataTable({
            //     aLengthMenu: [
            //         [50, 100, 200, 500, -1],
            //         [50, 100, 200, 500, "All"]
            //     ],
            //     'iDisplayLength': 100,
            //     scrollX: true,
            //     responsive: true,
            //     "scrollY": 400,
            //     "scrollCollapse": true,
            //     fixedColumns: {
            //         leftColumns: 4
            //     }
            // });
            let count = $("#editRuleMasterRowCount").val();
            // $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td><button id="removeRow" class="fa fa-minus btn btn-sm btn-danger removeRow" onclick="$(this).parent().parent().remove();"></button></td></tr>`);
            // $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td><button id="removeRow" class="fa fa-minus btn btn-sm btn-danger removeRow" onclick="$('#addRow').prop('disabled', false); let count = $('#ruleMasterRowCount').val(); let previousCount = parseInt(count) - 1; $('#ruleMasterRowCount').val(previousCount); $(this).parent().parent().remove();"></button></td></tr>`);
            // $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td><button id="removeRow" class="fa fa-minus btn btn-sm btn-danger removeRow""></button></td></tr>`);
            $("#editRuleMasterHeaders").after(
            `@if($masters)
            @foreach($masters as $master)
                <tr id="editInitial_`+ {{ $loop->iteration }} +`">
                    <td>`+ {{ $loop->iteration }} +`</td>
                    <td>
                        <select class="form-control" name="editRuleMaster_`+ {{ $loop->iteration }} +`" id="editRuleMaster_`+ {{ $loop->iteration }} +`"><option value="{{ $master -> id }}">{{ $master -> name }}</option> </select>
                    </td>
                    <td>
                        <button id="editRuleAddRow" class="fa fa-plus btn btn-sm btn-primary"></button>
                        <button id="editRuleRemoveRow" class="fa fa-minus btn btn-sm btn-danger"></button>
                    </td>
                </tr>
            @endforeach @endif`);
            // $("#ruleMasterRowCount").val(nextCount);
            //
            // $("#removeRow").prop("disabled", false);
            // $("#addRow").prop("disabled", false);
            //
            // if ($("#ruleMasterRowCount").val() == 5) {
            //     $("#addRow").prop("disabled", true);
            // }

            // let ruleMasterData = $('#ruleMasters').val();
            //
            // if (ruleMasterData != undefined) {
            //     $.each(JSON.parse(ruleMasterData), function( key, value ) {
            //         console.log('id: ' + value.id + ' | name: ' +value.name);
            //         console.log($('#ruleMaster_'+value.id).val());
            //         console.log($('#ruleCondition_'+value.id).val());
            //     });
            // }

            // $("#addRow").click(function () {
            //     var count = $("#count").val();
            //     count = parseInt(count) + 1;
            //     var html;
            //     html += '<tr>';
            //     html += '<td>' + count + '</td>';
            //     html += '<td>';
            //     html += '<select class="form-control">';
            //     html += '<option selected disabled>-- Select Condition --</option>';
            //     html += '<option>Treatment Type</option>';
            //     html += '<option>Case Type</option>';
            //     html += '<option>Case Status</option>';
            //     html += '<option>Location</option>';
            //     html += '<option>State </option>';
            //     html += '<option>City</option>';
            //     html += '<option>Master 1</option>';
            //     html += '<option>Master 2</option>';
            //     html += '<option>Master 3</option>';
            //     html += '</select>';
            //     html += '</td>';
            //     html += '<td><button class="fa fa-minus btn btn-sm btn-danger removeRow" onclick="$(this).parent().parent().remove();"></button></td>';
            //     html += '</tr>';
            //     $("#count").val(count);
            //     $("#initial").after(html);
            // });

            // $("#ruleNameNext").click(function(){
            //     $("ruleNameForm").submit(); // Submit the form
            // });

            let conditionMasterValues = <?php echo json_encode($masterValues) ?>;
            let rule = '<?php echo $rule;  ?>';
            $.each(conditionMasterValues, function(key, value) {
                let multipleValues = [];
                $.each(value, function(k,v) {
                    // console.log(v);
                    if (v === 'and' || v === 'or') {
                        $("#ruleCondition_"+key+"").val(v);
                    }
                    multipleValues.push(v);
                });
                $("#ruleMaster_"+key+"").val(multipleValues);
            });
            $('input:radio[name="ruleType"]').filter('[value="'+rule['ruletype']+'"]').attr('checked', true);
            $("#ruleFrequency").val(rule['rulefrequency']);
            $('#ruleSchedule option[value="'+rule['ruleschedule']+'"]').attr("selected", "selected");

            if (rule['ruletype'] === 'inbound') {
;                $("#ruleFrequency").attr('disabled','disabled');
                $("#ruleSchedule").attr('disabled','disabled');
            } else {
                $("#ruleFrequency").removeAttr('disabled');
                $("#ruleSchedule").removeAttr('disabled');
            }

        });
    </script>
    <script>

        function deleteRule(id) {
            if(confirm("Are you sure you want to delete this rule?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/conditions/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/rules";
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function deleteMaster(id) {
            if(confirm("Are you sure you want to delete this master?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/master/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/master";
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function deleteMainMaster(id, masterid) {
            if(confirm("Are you sure you want to delete this?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/master/main/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/master/main/"+masterid;
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function deleteDynamicMaster(id, masterid) {
            if(confirm("Are you sure you want to delete this master?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/dynamic/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/dynamic/"+masterid;
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function deleteLeave(id, employeeid) {
            if(confirm("Are you sure you want to delete this leave?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/leaves/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/leaves/"+employeeid;
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function deleteRole(id) {
            if(confirm("Are you sure you want to delete this role?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/role/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/role";
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function deleteCommunication(id) {
            if(confirm("Are you sure you want to delete this schedule?")){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/communications/destroy',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/communications";
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
            else{
                return false;
            }
        }

        function editCommunication(id) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/communications/'+id,
                type: 'GET',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'id': id
                },
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    let communicationSchedule = data['schedule'];
                    let type = communicationSchedule['type'];
                    $('#communicationId').val(communicationSchedule['id']);
                    $('.ruleId').val(communicationSchedule['rule_id']);
                    $('.communicationTemplateType').val(type);

                    if(type === 'WhatsApp') {
                        $(".communicationTemplateMessageDiv").show();
                        $(".communicationTemplateSubjectDiv").hide();
                        $(".communicationTemplateBodyDiv").hide();
                    }

                    if(type === 'Email') {
                        $(".communicationTemplateMessageDiv").hide();
                        $(".communicationTemplateSubjectDiv").show();
                        $(".communicationTemplateBodyDiv").show();
                    }

                    $('.communicationTemplateId').val(communicationSchedule['template_id']);
                    $('.communicationTemplateSubject').val(communicationSchedule['subject']);
                    $('.communicationTemplateMessage').val(communicationSchedule['message']);
                    $('.communicationTemplateBody').val(communicationSchedule['content']);

                    let schedule = communicationSchedule['schedule'];

                    if (schedule === 'now') {
                        $('input:radio[name="schedule"]').filter('[value="'+schedule+'"]').attr('checked', true);
                        $("#editCommunicationNowDiv *").prop('disabled',true);
                        $("#editCommunicationScheduleDiv *").prop('disabled',true);
                    } else {
                        $("#editCommunicationScheduleDiv *").prop('disabled',false);
                        $("#editCommunicationNowDiv *").prop('disabled',false);
                    }

                    $('#editSchedule').modal('show');
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        }

        function editLead(id) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/leads/'+id,
                type: 'GET',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'id': id
                },
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    let lead = data['lead'];
                    let leadmasters = data['leadmasters'];
                    $('.leadId').val(lead['id']);
                    $('.leadName').val(lead['name']);
                    $('.leadEmail').val(lead['email']);
                    $('.leadMobile').val(lead['mobileno']);
                    $('.leadAlternateMobile').val(lead['altmobileno']);
                    $('.leadReceivedDate').val(lead['receiveddate']);

                    $.each(leadmasters, function(key, value) {
                        if(value != null) {
                            let mastervalue = value['mastervalue_id'];
                            if (mastervalue == null) {
                                mastervalue = 0;
                            }
                            $(".leadMaster_"+value['master_id']+"").val(mastervalue);
                        }
                    });

                    $('#editSingleLead').modal('show');
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        }

        function handleChange(cb) {
            console.log("Changed, new value = " + cb.checked);
            $(cb).attr('value', cb.checked);
        }

        $("#editLeadDetails").click(function(){
            let leadMasters = <?php echo json_encode($leadMasters) ?>;
            $.each(leadMasters, function(key, value) {
                if(value != null) {
                    $("#leadMaster_"+key+"").val(value);
                }
            });
        });

        $("#addRow").click(function (e) {
            e.preventDefault();
            let count = $("#ruleMasterRowCount").val();
            console.log(count);
            let nextCount = parseInt(count) + 1;
            console.log(nextCount);
            // $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td><button id="removeRow" class="fa fa-minus btn btn-sm btn-danger removeRow" onclick="$(this).parent().parent().remove();"></button></td></tr>`);
            $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td></td></tr>`);
            // $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td><button id="removeRow" class="fa fa-minus btn btn-sm btn-danger removeRow" onclick="$('#addRow').prop('disabled', false); let count = $('#ruleMasterRowCount').val(); let previousCount = parseInt(count) - 1; $('#ruleMasterRowCount').val(previousCount); $(this).parent().parent().remove();"></button></td></tr>`);
            // $("#initial_"+count+"").after(`<tr id="initial_`+nextCount+`"><td>`+nextCount+`</td><td><select class="form-control" name="ruleMaster_`+nextCount+`" id="ruleMaster_`+nextCount+`"><option selected disabled>-- Select Condition --</option></select></td><td><button id="removeRow" class="fa fa-minus btn btn-sm btn-danger removeRow""></button></td></tr>`);
            
            $("#ruleMaster_"+nextCount+"").append(`@if($masters) 
                @foreach($masters as $master) 
                <option value="{{ $master -> id }}">{{ $master -> name }}</option> @endforeach
                @endif`);
            
            $("#ruleMasterRowCount").val(nextCount);

            $("#removeRow").prop("disabled", false);
            $("#addRow").prop("disabled", false);

            if ($("#ruleMasterRowCount").val() == 5) {
                $("#addRow").prop("disabled", true);
            }
        });

        $("#removeRow").click(function (e) {
            e.preventDefault();
            let count = $("#ruleMasterRowCount").val();
            $("#initial_"+count+"").remove();
            let previousCount = parseInt(count) - 1;
            $("#ruleMasterRowCount").val(previousCount);

            $("#removeRow").prop("disabled", false);
            $("#addRow").prop("disabled", false);

            if ($("#ruleMasterRowCount").val() == 1) {
                $("#removeRow").prop("disabled", true);
            }

        });

        // {
        //     "Actors": [
        //     {
        //         "name": "Tom Cruise",
        //         "age": 56,
        //         "Born At": "Syracuse, NY",
        //         "Birthdate": "July 3, 1962",
        //         "photo": "https://jsonformatter.org/img/tom-cruise.jpg",
        //         "wife": null,
        //         "weight": 67.5,
        //         "hasChildren": true,
        //         "hasGreyHair": false,
        //         "children": [
        //             "Suri",
        //             "Isabella Jane",
        //             "Connor"
        //         ]
        //     }
        // }

        // $("#ruleConditionSubmit").click(function(){
        //
        //     //let jsonObject = new Object();
        //     let jsonObject = [];
        //     // jsonObject.name = $('#ruleName').val();
        //     // let ruleName = $('#ruleName').val();
        //     let ruleMasterData = $('#ruleMasters').val();
        //     let items = [];
        //     $.each(JSON.parse(ruleMasterData), function (key, value) {
        //         // item ["master"] = value.id;
        //
        //         let itemValue = {};
        //         //let master = []
        //         let masterValues = [];
        //         let masterOperations = [];
        //
        //         //master.push(value.id);
        //         itemValue ["master"] = value.id;
        //         $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
        //             masterValues.push($(sel).val());
        //         });
        //         itemValue ["masterValues"] = masterValues;
        //         $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
        //             masterOperations.push($(sel).val());
        //         });
        //         itemValue ["masterOperations"] = masterOperations;
        //
        //         items.push(itemValue);
        //
        //     });
        //     //jsonObject.masters = item;
        //     jsonObject.push(items)
        //     console.log(JSON.stringify(items));
        //     // let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     // $.ajaxSetup({
        //     //     headers: {
        //     //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     //     }
        //     // });
        //     // $.ajax({
        //     //     /* the route pointing to the post function */
        //     //     url: '/conditions/store',
        //     //     type: 'POST',
        //     //     /* send the csrf-token and the input to the controller */
        //     //     // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
        //     //     data: {_token: CSRF_TOKEN, 'ruleName': ruleName, 'ruleData':JSON.stringify(jsonObject)},
        //     //     // data: $(this).serialize(),
        //     //     dataType: 'JSON',
        //     //     /* remind that 'data' is the response of the AjaxController */
        //     //     success: function (data) {
        //     //         console.log(data);
        //     //         window.location.href = "/rules";
        //     //     },
        //     //     failure: function (data) {
        //     //         console.log(data);
        //     //     }
        //     // });
        // });


        $("#ruleConditionSubmit").click(function(){
        //WORKING
        //     let jsonObject = [];
        //     let ruleName = $('#ruleName').val();
        //     let ruleMasterData = $('#ruleMasters').val();
        //     $.each(JSON.parse(ruleMasterData), function (key, value) {
        //         let item = {}
        //         item ["master"] = value.id;
        //
        //         let masterValues = [];
        //
        //         $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
        //             if ($(sel).val() != "--Select Condition--") {
        //                 masterValues.push($(sel).val());
        //             }
        //         });
        //         item ["masterValues"] = masterValues;
        //         $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
        //             if ($(sel).val() != "--Select Condition--") {
        //                 item ["ruleOperation"] = $(sel).val();
        //             }
        //         });
        //
        //         jsonObject.push(item);
        //
        //     });
        //     console.log(JSON.stringify(jsonObject));
            // WORKING

                //let jsonObject = new Object();
                //let jsonObject = [];
                // jsonObject.name = $('#ruleName').val();
                let ruleName = $('#ruleName').val();
                let ruleMasterData = $('#ruleMasters').val();
                let ruleType = $("input[name='ruleType']:checked").val();
                let ruleFrequency = $('#ruleFrequency').val();
                let ruleSchedule = $('#ruleSchedule :selected').val();
                let items = [];
                $.each(JSON.parse(ruleMasterData), function (key, value) {
                    // item ["master"] = value.id;

                    let itemValue = {};
                    let master = [];
                    let masterValues = [];
                    let masterOperations = [];

                    master.push(value.id);
                    itemValue ["master"] = master;
                    $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
                        masterValues.push($(sel).val());
                    });
                    itemValue ["masterValues"] = masterValues;
                    $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
                        masterOperations.push($(sel).val());
                    });
                    itemValue ["masterOperations"] = masterOperations;

                    items.push(itemValue);

                });
                //jsonObject.masters = item;
                //jsonObject.push(items)
                // console.log(JSON.stringify(items));

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/conditions/store',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'ruleName': ruleName,
                        'ruleData':JSON.stringify(items),
                        'ruleType': ruleType,
                        'ruleFrequency': ruleFrequency,
                        'ruleSchedule':ruleSchedule
                    },
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    window.location.href = "/rules";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        });

        $("#editRuleConditionSubmit").click(function(){
            let ruleId = $('#ruleId').val();
            let ruleName = $('#ruleName').val();
            let ruleMasterData = $('#ruleMasters').val();
            let ruleType = $("input[name='ruleType']:checked").val();
            let ruleFrequency = $('#ruleFrequency').val();
            let ruleSchedule = $('#ruleSchedule :selected').val();
            let items = [];
            $.each(JSON.parse(ruleMasterData), function (key, value) {
                let itemValue = {};
                let master = [];
                let masterValues = [];
                let masterOperations = [];

                master.push(value.id);
                itemValue ["master"] = master;
                $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
                    masterValues.push($(sel).val());
                });
                itemValue ["masterValues"] = masterValues;
                $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
                    masterOperations.push($(sel).val());
                });
                itemValue ["masterOperations"] = masterOperations;

                items.push(itemValue);

            });

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/conditions/update',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'ruleId':ruleId,
                    'ruleName': ruleName,
                    'ruleData':JSON.stringify(items),
                    'ruleType': ruleType,
                    'ruleFrequency': ruleFrequency,
                    'ruleSchedule':ruleSchedule
                },
                // data: $(this).serialize(),
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    window.location.href = "/rules";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        });

        $("#leadMasterSubmit").click(function(){

            let leadMastersData = $('#leadMasters').val();

            let name = $('#name').val();
            let email = $('#email').val();
            let mobileno = $('#mobileno').val();
            let altmobileno = $('#altmobileno').val();
            let receiveddate = $('#receiveddate').val();
            let remark = $('#remark').val();
            let items = [];
            $.each(JSON.parse(leadMastersData), function (key, value) {

                let itemValue = {};
                // let master = []
                // let masterValues = [];
                let masterOperations = [];

                // master.push(value.id);
                itemValue ["master"] = value.id;
                // $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
                //     masterValues.push($(sel).val());
                // });
                let $masterValue = $('#leadMaster_' + value.id + ' :selected').val();
                if ($masterValue != "-- Select Condition --") {
                    itemValue ["masterValue"] = $masterValue;
                } else {
                    itemValue ["masterValue"] = null;
                }
                // $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
                //     masterOperations.push($(sel).val());
                // });
                // itemValue ["masterOperations"] = masterOperations;

                items.push(itemValue);

            });
            //jsonObject.masters = item;
            //jsonObject.push(items)
            // console.log(JSON.stringify(items));


            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/leads/store',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'name': name,
                    'email': email,
                    'mobileno': mobileno,
                    'altmobileno': altmobileno,
                    'receiveddate': receiveddate,
                    'remark': remark,
                    'leadMasterData':JSON.stringify(items)
                },
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    window.location.href = "/leads";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        });

        $("#mastersTab").click(function(){

            let employeeId = $('#employeeId').val();
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                /* the route pointing to the post function */
                url: '/employees/permissions/'+ employeeId + '/masters',
                type: 'GET',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    let allMasters = data['masters'];
                    $("#permissionsTab").removeClass("active");
                    $("#masterTab").addClass("active");
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        });

        $('select[name="templateType"]').change(function() {
            if($(this).val() === 'WhatsApp') {
                $("#templateMessageDiv").show();
                $("#templateSubjectDiv").hide();
                $("#templateEmailDiv").hide();
            }

            if($(this).val() === 'Email') {
                $("#templateMessageDiv").hide();
                $("#templateSubjectDiv").show();
                $("#templateEmailDiv").show();
            }
        });

        $('select[name="communicationTemplateType"]').change(function() {
            console.log("Here");
            if($(this).val() === 'WhatsApp') {
                $("#communicationTemplateMessageDiv").show();
                $("#communicationTemplateSubjectDiv").hide();
                $("#communicationTemplateBodyDiv").hide();
            }

            if($(this).val() === 'Email') {
                $("#communicationTemplateMessageDiv").hide();
                $("#communicationTemplateSubjectDiv").show();
                $("#communicationTemplateBodyDiv").show();
            }

            let templateType = $(this).val();
            $(".removableTemplate").remove();
            if(templateType !== 'NA') {
                $.ajax({
                    url: '/communications/templates/'+templateType,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data) {
                        let templates = data.template;
                        templates.forEach(function(template) {
                            $("#communicationTemplateId, #editCommunicationTemplateId").append(`<option class="removableTemplate" value="`+template.id+`">`+template.name+`</option>`);
                        });

                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }

        });

        $("#communicationSchedule, .communicationSchedule").click(function() {
            $("#communicationScheduleDiv *, #editCommunicationScheduleDiv *").prop('disabled',false);
            $("#communicationNowDiv *, #editCommunicationNowDiv *").prop('disabled',false);
        });

        $("#communicationNow, .communicationNow").click(function() {
            $("#communicationNowDiv *, #editCommunicationNowDiv *").prop('disabled',true);
            $("#communicationScheduleDiv *, #editCommunicationScheduleDiv *").prop('disabled',true);
        });

        $("#inboundRule").click(function() {
            $("#outboundDiv *").prop('disabled',true);
            $("#ruleFrequency").val('');
            $("#ruleSchedule").val('NA');
        });

        $("#outboundRule").click(function() {
            $("#outboundDiv *").prop('disabled',false);
        });

        $('select[name="scheduleUnit"]').change(function() {
            if($(this).val() === 'DAILY') {
                // $("#dayOfWeekDiv *, #dayOfMonthDiv *").prop('disabled',false);
                // $("#dayOfWeekDiv").val('NA').change();
                // $("#dayOfMonthDiv").val('NA').change();
                $("#dayOfWeekDiv *, #dayOfMonthDiv *").prop('disabled',true);
                $("#minuteHour").val("00:00");
            } else if ($(this).val() === 'WEEKLY') {
                $("#dayOfWeekDiv *").prop('disabled',false);
                $("#dayOfMonthDiv *").prop('disabled',true);
                $("#minuteHour").val("00:00");
            } else if ($(this).val() === 'MONTHLY') {
                $("#dayOfWeekDiv *, #dayOfMonthDiv *").prop('disabled',false);
            } else {
                $("#dayOfWeekDiv *, #dayOfMonthDiv *").prop('disabled',false);
            }
        });

        $("#employeePermissionSubmit").click(function(){

            //Rules

            let employeeId = $("#employeeId").val();
            let rules = $("#employeePermissionRules").val();

            let items = [];
            $.each(JSON.parse(rules), function (key, value) {

                let itemValue = {};
                itemValue ["rule"] = value.id;
                // console.log(value.id);
                let $ruleStatus = $('#rule_' + value.id).val();
                itemValue ["ruleStatus"] = $ruleStatus;
                // console.log($ruleStatus);
                items.push(itemValue);

            });

            //jsonObject.masters = item;
            //jsonObject.push(items)
            // console.log(JSON.stringify(items));


            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/employees/permissions/'+employeeId,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'employeeId': employeeId,
                    'rulesDate':JSON.stringify(items)
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    window.location.href = "/employees/permissions";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        });


        $(".update-menu-permission").click(function(){
            const self = this;
            bootbox.confirm({
                message: "Do you really want to update permission for this menu item?.",
                callback: function (confirm) {
                    if(confirm) {
                        processSingleMenuPermissionUpdate(self);
                    }
                    else {
                        window.location.reload();
                    }
                }
            });

        });

        function processSingleMenuPermissionUpdate(self) {
            const datamenuid = $(self).attr("data-menuid");
            const dataempid = $(self).attr("data-empid");
            let employeeId = $("#employeeId").val();
            console.log("---datamenuid--",datamenuid,"===dataempid==",dataempid);
            const add_permission_val =  $('#add_menu_' + datamenuid).val();
            const edit_permission_val =  $('#edit_menu_' + datamenuid).val();
            const delete_permission_val =  $('#delete_menu_' + datamenuid).val();
            const view_permission_val =  $('#view_menu_' + datamenuid).val();
            const menu_parent_id =  $('#parent_menu_' + datamenuid).val();
            console.log("--menu_parent_id-",menu_parent_id);
            const permissionData = {
                'menu_id':datamenuid,
                'employee_id':employeeId,
                'add_permissions':(add_permission_val == 1 || add_permission_val == "true" )?1:0,
                'edit_permissions':(edit_permission_val == 1 || edit_permission_val == "true" )?1:0,
                'delete_permissions':(delete_permission_val == 1 || delete_permission_val == "true" )?1:0,
                'view_permissions':(view_permission_val == 1 || view_permission_val == "true" )?1:0,
                'parent_id' : menu_parent_id
            }

            console.log(permissionData);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/menus/set-single-permissions/'+employeeId,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'employeeId': employeeId,
                    // 'rulesDate':JSON.stringify(items)
                    'permissionData':JSON.stringify(permissionData)
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (response) {
                    if(response?.message) {
                        bootbox.confirm({
                            message: "<p class='text-success ml-3 px-3 p-3 font-weight-bold'>"+response.message+"</p><p></p><p class='text-center font-weight-bold'><ul><li>Click 'OK' to redirect to employee list page.</li><li> Click 'Cancel' to reload the page. </li></ul></p>",
                            callback: function (confirm) {
                                if(confirm) {
                                    window.location.href = "/permissions/employee-list";
                                }
                                else {
                                    window.location.reload();
                                }
                            }
                        })
                    }
                },
                failure: function (data) {
                    console.log("failure response",data);
                    bootbox.alert("Request Failed!");
                },
                done: function (data) {
                    bootbox.alert("Request Completed!");
                },

                error: function (data) {
                    if(data?.responseText) {
                        const jsonResp = JSON.parse(data.responseText);
                        bootbox.confirm(jsonResp.message, function(resp){
                            location.reload();
                        });
                    }

                }
            });
        }

        $("#employeeMenuPermissionbtn").click(function(){
            let employeeId = $("#employeeId").val();
            let allPermissions = $("#allPermissions").val();
            console.log("---allPermissions--",allPermissions);
            let items = [];
            $.each(JSON.parse(allPermissions), function (key, value) {
                let itemValue = {};
                itemValue ["id"] = value.mId;
                itemValue ["menu_id"] = value.id;
                const add_permission_val =  $('#add_menu_' + value.id).val();
                const edit_permission_val =  $('#edit_menu_' + value.id).val();
                const delete_permission_val =  $('#delete_menu_' + value.id).val();
                const view_permission_val =  $('#view_menu_' + value.id).val();
                const menu_parent_id =  $('#parent_menu_' + value.id).val();
                itemValue ["add_permissions"] = (add_permission_val == 1 || add_permission_val == "true" )?1:0;
                itemValue ["edit_permissions"] = (edit_permission_val == 1 || edit_permission_val == "true" )?1:0;
                itemValue ["delete_permissions"] = (delete_permission_val == 1 || delete_permission_val == "true" )?1:0;
                itemValue ["view_permissions"] = (view_permission_val == 1 || view_permission_val == "true" )?1:0;
                itemValue ["parent_id"] = menu_parent_id;
                items.push(itemValue);
            });
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/menus/set-all-permissions/'+employeeId,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'employeeId': employeeId,
                    // 'rulesDate':JSON.stringify(items)
                    'permissionsData':JSON.stringify(items)
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log("success response",data);
                   // window.location.href = "/permissions/employee-list";
                },
                error: function (jqXHR, exception) {
                    const jsonResp = JSON.parse(data.responseText);
                    alert(jsonResp.message);
                    //location.reload();
                },
                failure: function (data) {
                    console.log("failure response",data);
                }
            });
        });


            $('select[name="communicationTemplateId"]').change(function() {

            let templateId = $(this).val();

            if(templateId !== 'NA') {
                $.ajax({
                   url: '/communications/templates/'+templateId,
                   type: 'GET',
                   dataType: 'JSON',
                   success: function (data) {
                       console.log(data);
                       if (data.template.type === 'Email') {
                           $("#communicationTemplateSubject").val(data.template.subject);
                       } else if (data.template.type === 'WhatsApp') {
                            $("#communicationTemplateMessage").val(data.template.message)
                       }
                   },
                   failure: function (data) {
                       console.log(data);
                   }
               });
           }
        });

        $('select[name="leadEmailTemplateId"]').change(function() {

            let templateId = $(this).val();

            if(templateId !== 'NA') {
                $.ajax({
                    url: '/communications/templates/'+templateId,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        $("#leadEmailSubject").val(data.template.subject);
                        $("#leadEmailBody").val(data.template.body);
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
        });

        $('select[name="leadWhatsAppTemplateId"]').change(function() {

            let templateId = $(this).val();

            if(templateId !== 'NA') {
                $.ajax({
                    url: '/communications/templates/'+templateId,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#leadWhatsAppMessage").val(data.template.message);
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
        });

        // Lead Call Send Email
        $('#leadSendEmail').click(function() {
            let leadId = $('#leadId').val();
            let employeeId = $("#leadEmployeeId").val();
            let templateId = $("#leadEmailTemplateId").val();
            let emailId = $("#leadEmailId").val();
            let remark = $("#leadCallRemark").val();
            let reminderDate = $("#leadNextReminderDate").val();


            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(templateId !== 'NA') {
                $.ajax({
                    url: '/leads/calls/'+leadId+'/email',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        'leadId': leadId,
                        'employeeId': employeeId,
                        'templateId': templateId,
                        'emailId': emailId,
                        'type': 'Email',
                        'remark': remark,
                        'reminderDate': reminderDate
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        // $("#spinner-div").hide();
                        window.location.href = '/leads/calls/'+leadId;
                    },
                    failure: function (data) {
                        // $("#spinner-div").hide();
                        console.log(data);
                    }
                });
            }
        });

        // Lead Call Send WhatsApp
        $('#leadSendWhatsApp').click(function() {

            let leadId = $('#leadId').val();
            let employeeId = $("#leadEmployeeId").val();
            let templateId = $("#leadWhatsAppTemplateId").val();
            let mobileno = $("#leadWhatsAppMobileNo").val();
            let callStatusId = $("#callStatusId").val();
            let remark = $("#leadCallRemark").val();
            let reminderDate = $("#leadNextReminderDate").val();

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(templateId !== 'NA') {
                $.ajax({
                    url: '/leads/calls/'+leadId+'/whatsapp',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        'leadId': leadId,
                        'employeeId': employeeId,
                        'templateId': templateId,
                        'mobileno' : mobileno,
                        'type': 'WhatsApp',
                        'callStatusId': callStatusId,
                        'remark': remark,
                        'reminderDate': reminderDate
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        window.location.href = '/leads/calls/'+leadId;
                    },
                    failure: function (data) {
                        console.log(data);
                    }
                });
            }
        });

        $('#submitLeadCall').click(function() {
            let leadId = $('#leadId').val();
            let employeeId = $("#leadEmployeeId").val();
            let reminderDate = $("#leadNextReminderDate").val();
            let remark = $("#leadCallRemark").val();


            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/leads/calls/'+leadId+'/call',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'leadId': leadId,
                    'employeeId': employeeId,
                    'remark': remark,
                    'reminderDate': reminderDate
                },
                dataType: 'JSON',
                success: function (data) {
                    window.location.href = '/leads/calls/'+leadId+'';
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        });

    </script>
    {{--<script>
         $(function () {
            // $("ruleConditionForm").on("submit", function (e) {
             $("#ruleConditionSubmit").click(function(e) {
                e.preventDefault();
                let jsonObject = [];
                jsonObject['rule'] = $("#ruleName").val();
                let ruleMasterData = $('#ruleMasters').val();
                $.each(JSON.parse(ruleMasterData), function (key, value) {
                    let item = {}
                    item ["master"] = value.id;

                    let masterValues = [];

                    $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
                        if ($(sel).val() != "--Select Condition--") {
                            masterValues.push($(sel).val());
                        }
                    });
                    item ["masterValues"] = masterValues;
                    $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
                        if ($(sel).val() != "--Select Condition--") {
                            item ["ruleOperation"] = $(sel).val();
                        }
                    });

                    jsonObject.push(item);

                });

                console.log(JSON.stringify(jsonObject));

                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                         'Content-Type': 'application/json'
                     },
                     data: {
                         _token: $('meta[name="csrf-token"]').attr('content')
                     }
                 });
                $.ajax({
                    url:'/rules/create/condition',
                    dataType: 'json', // what to expect back from the server
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: JSON.stringify(jsonObject),
                    type: "POST",
                    success:(data) => {
                        console.log(data);
                    },
                    failure:(data) => {
                        console.log(data);
                    }
                });
            });
         });


        /*

        master
            values
                operation
        master
            values
                operation

         */

        // $("#ruleConditionSubmit").click( function () {
        //     let ruleMasterData = $('#ruleMasters').val();
        //     $.each(JSON.parse(ruleMasterData), function( key, value ) {
        //         console.log('id: ' + value.id + ' | name: ' +value.name);
        //         $('#ruleMaster_'+value.id+' :selected').each(function(i, sel){
        //             console.log( $(sel).val() );
        //         });
        //         $('#ruleCondition_'+value.id+' :selected').each(function(i, sel){
        //             console.log( $(sel).val() );
        //         });
        //     });
        // });

    </script>--}}
    <script>
        CKEDITOR.replace("communicationTemplateBody", {
            height: 200
        });
        CKEDITOR.replace("templateEmailBody", {
            height: 200
        });
    </script>
    <script>
        function dash() {
            var ctx = document.getElementById("singelBarChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["November", "December"],
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
                        "october", "November", "December"
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
</body>
@stack('custom-scripts')
</html>
