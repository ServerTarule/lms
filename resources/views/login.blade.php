<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>CRM LOGIN</title>
      <link rel="shortcut icon" href="{{asset('assets/dist/img/mini-logo.png')}}" type="image/x-icon">
      <link href="{{asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/plugins/lobipanel/lobipanel.min.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/plugins/pace/flash.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/themify-icons/themify-icons.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/plugins/emojionearea/emojionearea.min.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/plugins/monthly/monthly.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/dist/css/stylecrm.css')}}" rel="stylesheet" type="text/css"/>
      <link href="http://lasik.tarule.in/css/dataTables.bootstrap.min.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
   </head>
   <body class="sidebar-mini  pace-done sidebar-collapse">
      <div id="preloader">
         <div id="status"></div>
      </div>
      <div class="wrapper">
		<div class="login-wrapper">
            <div class="container-center">
            <div class="login-area">
                <div class="panel panel-bd panel-custom">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Login</h3>
                                <small><strong>Please enter your credentials to login.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                        <span style="color:red;">
                        {{session('status')}}</span>
                        @endif
                        <form action="/postlogin" id="loginForm" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="control-label" for="username">Email</label>
                                <input type="text" placeholder="Enter Your email" title="Please enter you username" required="" value="" name="email" id="username" class="form-control">
                                <span class="help-block small">Your unique email to app</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                                <span class="help-block small">Your strong password</span>
                            </div>
                            <div>
                                <button class="btn btn-add" type="Submit">Login</button>
                            </div>
                        </form>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets//plugins/jQuery/jquery-1.12.4.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/lobipanel/lobipanel.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript">    </script>
    <script src="{{asset('assets//plugins/fastclick/fastclick.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//dist/js/custom.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/chartJs/Chart.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/counterup/waypoints.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//plugins/monthly/monthly.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets//dist/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="http://lasik.tarule.in/js/jquery.dataTables.min.js"></script>
    <script src="http://lasik.tarule.in/js/dataTables.bootstrap.min.js"></script>
  <script src="http://lasik.tarule.in/ckeditor/samples/js/sample.js"></script>
  <script src="http://lasik.tarule.in/ckeditor/styles.js"></script>
  <script src="http://lasik.tarule.in/ckeditor/ckeditor.js"></script>
  <script>
      CKEDITOR.replace("Comments",
  {
      height: 200
  });
       CKEDITOR.replace("Comments2",
  {
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
       datasets: [
       {
       label: "Count",
       data: [12,5],
       borderColor: "rgba(0, 150, 136, 0.8)",
       width: "1",
       borderWidth: "0",
       backgroundColor: "rgba(0, 150, 136, 0.8)"
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
       labels: ["January", "February", "March", "April", "May", "June", "July", "august", "september","october", "Nobemver", "December"],
       datasets: [
       {
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
      $(document).ready(function () {
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


