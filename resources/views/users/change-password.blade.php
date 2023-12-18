@extends('layout.app')
@section('title', 'Manage Templates')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>User Profile</h4>
                        </a>
                    </div>
                </div>
                @if (session('status'))
                <span style="color:#00b100;">{{ session('status') }}</span>
            @endif
            @if (session('error'))
                <span style="color:#b10000;">{{ session('error') }}</span>
            @endif
                <div class="panel-body">
                    <div class="text-right">
                        <p class="lead">
                            <a onclick="window.history.back()" class="btn btn-sm btn-danger">
                                <i class='fa fa-arrow-circle-left fa-2x' style="color:white;"> <span  style="font-family:ui-rounded;">Back</span></i>
                            </a>
                        </p>
                        
                    </div>
                    <div class="col-md-12">
                        {{-- <form class="form-horizontal" id="updateProfile" method="POST"> --}}
                        <form  method="post" id="updatePassword" class="form-horizontal" enctype="multipart/form-data" >
                            @csrf
                            <fieldset>
                               <input type="hidden" id="userid" name="userid" value="{{$userProfileDetail->id}}">
                                <div class="col-md-2 form-group text-left">
                                    <label class="control-label">Email</label>
                                </div>
                                <div class="col-md-4 form-group text-left">
                                    <input type="text" id="userEmail" name="email" placeholder="Email" value="{{$userProfileDetail->email}}"  class="form-control" readonly>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="control-label">Role</label>
                                </div>
                                <div class="col-md-4 form-group text-left">
                                    <input type="text" id="roleName" placeholder="Role" value="{{$userProfileDetail->role->name}}"  class="form-control" readonly>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="control-label">Name</label>
                                </div>
                                <div class="col-md-4 form-group text-left">
                                    <input type="text" id="name" name="name" placeholder="Name" value="{{$userProfileDetail->name}}" class="form-control" readonly/>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="control-label">Current Password<sup class="text-danger font-weight-bold">*</sup></label>
                                </div>
                                <div class="col-md-4 form-group text-left">
                                    <input type="password" id="currentpassword" name="currentpassword" placeholder="Current Password" value=""  class="form-control">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="control-label">New Password<sup class="text-danger font-weight-bold">*</sup></label>
                                </div>
                                <div class="col-md-4 form-group text-left">
                                    <input type="password" id="newpassword" name="newpassword" placeholder="New Password" value=""  class="form-control">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="control-label">Confirm Password<sup class="text-danger font-weight-bold">*</sup></label>
                                </div>
                                <div class="col-md-4 form-group text-left">
                                    <input type="text" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" value=""  class="form-control">
                                </div>
                            </fieldset>
                        </form>
                        <div class="col-md-12 form-group text-right">
                            <button type="button" id="updatePasswordBtn"  class="btn btn-add btn-sm">Update Password</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
<script>
    function validateForm() {
        const currentpassword  = $("#currentpassword").val();
        const newpassword  = $("#newpassword").val();
        const confirmpassword  = $("#confirmpassword").val();

        if(currentpassword == "") {
            toastr.error("Please fill a current password!");
            return false;
        }
        else if(newpassword == "") {
            toastr.error("Please fill a new password!");
            return false;
        }
        else if(confirmpassword == "") {
            toastr.error("Please fill a confirm password!");
            return false;
        }
        else if(newpassword != confirmpassword ) {
            toastr.error("New password and confirm password are not same!");
            return false;
        }
        else {
            return true;
        }

    }
    
    $("#updatePasswordBtn").click(function(){
        updateProfile()
    });
    function updateProfile () {
        const isValid = validateForm();
        if(isValid) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // const userid = $("#userid").val();
            var form_data = new FormData($('#updatePassword')[0]);
            // alert("I am here"+employeeId+"----"+userId);
            $.ajax({
                /* the route pointing to the post function */
                url: `/users/updatepassword`,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                contentType: false,
                processData: false,
                data:  form_data,
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if(data.error) {
                        toastr.error(data.message);
                    }
                    else {
                        toastr.success(data.message);
                        setTimeout(function(){ 
                            location.reload();
                        }, 3000);
                    }
                },
                failure: function (data) {
                    toastr.error("Error occurred while processing!!");
                },
                error:function(xhr, status, error) {
                    const resText = JSON.parse(xhr.responseText);
                    toastr.error( resText.message);
                },
            });
        }
        

    }

</script>
@endpush