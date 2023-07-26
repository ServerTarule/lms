@extends('layout.app')
@section('title', 'Manage Employee')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Adminmaster Status</h4>
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
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i class="fa fa-plus"></i>
                            Add Employee</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Admin Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Employee ID</a>
                                    </th>
                                    <th scope="col">
                                        <a>Mobile No</a>
                                    </th>
                                    <th scope="col">
                                        <a>User Type</a>
                                    </th>
                                    <th scope="col">
                                        <a>Email id</a>
                                    </th>
                                    <th scope="col">
                                        <a>Password</a>
                                    </th>
                                    <th scope="col">
                                        <a>DOB</a>
                                    </th>
                                    <th scope="col">
                                        <a>DOJ</a>
                                    </th>
                                    <th scope="col">
                                        <a>Alternate Mobile No</a>
                                    </th>
                                    <th scope="col">
                                        <a>Designation Type</a>
                                    </th>
                                    <th scope="col">
                                        <a>Profile Image</a>
                                    </th>
                                    <!--  <th scope="col">
                              <a>Max/Per Day</a>
                          </th>
                          <th scope="col">
                              <a>Max/Per Weekly</a>
                          </th> -->
                                    <th scope="col">
                                        <a>Edit</a>
                                    </th>
                                    <th scope="col">
                                        <a>Active</a>
                                    </th>
                                    {{-- <th scope="col">
                                        <a>Block/Unblock</a>
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee as $employe)
                                    <tr>
                                        <td>{{ $employe->id }}</td>
                                        <td>{{$employe->name }}</td>
                                        <td>{{ $employe->name }}</td>
                                        <td>123456</td>
                                        <td>{{ $employe->contact }}</td>
                                        <td>
                                            {{$employe->designation_id}}

                                        </td>
                                        <td>
                                            {{$employe->user->email}}
                                        </td>
                                        <td>*******</td>
                                        <td>{{$employe->dob}}</td>
                                        <td>{{$employe->doj}}</td>
                                        <td>{{$employe->alternate_contact}}</td>

                                        <td>
                                            {{$employe->designation->name}}
                                        </td>
                                        <td>
                                            @if ($employe->profile_img)
                                                <img src="{{$employe->profile_img}}" height="40px" width="40px" />
                                            @elseif (!$employe->profile_img || $employe->profile_img =='user.png')
                                                No Image
                                            @endif
                                        </td>

                                        <!-- <td>
								            <a data-toggle="modal" data-target="#editEmployee" class="btn-xs btn-info"> <i class="fa fa-edit">Edit</i></a>
								        </td> -->
                                        <td>
                                            <a onclick="return editEmployee({{ $employe->id }})" class="btn-xs btn-info"> <i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a href=""onclick="if (confirm('are you sure you want to cancel?')) window.location.href='/cancel';                                            "
                                                class="btn-xs btn-info" style="background: #337ab7;">
                                                <span>Active</span>
                                            </a>
                                        </td>
                                        {{-- <td>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Add EMPLOYEE </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                        <!-- onSubmit="return  submitAddForm()" -->
                            <form  method="post" id="addEmployeeForm" class="form-horizontal" enctype="multipart/form-data"  action="/createemployee">
                                @csrf
                                <fieldset>
                                    <!-- <span class="required text-danger"> * </span> -->
                                    <div class="col-md-12 form-group">
                                        <label>Admin Name </label>
                                        <select class="form-control" name="role_id" id="role_id" multiple>
                                          @foreach ($user as $users )
                                            <option value="{{$users->id}}">{{$users->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Employee Name <span class="required text-danger"> * </span></label>
                                        <input type="text" placeholder="Enter Employee Name" name="name" id="emp_name" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Mobile Number <span class="required text-danger"> * </span></label>
                                        <input type="text" placeholder="Enter Mobile Number" id="contact" name="contact" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">User Type</label>
                                        <select class="form-control" name="user_type"  id="user_type"  disabled>
                                            @foreach ($role as $roles )
                                              <option value="{{$roles->id}}">{{$roles->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Email Id <span class="required text-danger"> * </span> </label>
                                        <input type="email" placeholder="Enter Email Id" id="email"  name="email" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Password <span class="required text-danger"> * </span></label>
                                        <input type="password" placeholder="Enter Password" id="password"  name="password" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">DOB <span class="required text-danger"> * </span></label>
                                        <input type="date" placeholder="Enter DOB" id="dob" name="dob" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">DOJ <span class="required text-danger"> * </span></label>
                                        <input type="date" placeholder="DOJ" id="doj" name="doj" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Alternate Mobile Number </label>
                                        <input type="text" placeholder="Alternate Mobile Number" id="alternate_contact" name="alternate_contact" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Designation Type</label>
                                       <select class="form-control" name="designation_id" id="designation_id">
                                            @foreach ($designation as $designations )
                                              <option value="{{$designations->id}}">{{$designations->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Profile Image </label>
                                        <input type="file" class="form-control" id="profile_image" name="file">
                                        <!-- <input type="hidden" class="form-control" value="user.png" name="profile_img"> -->
                                    </div>
                                    <!--   <div class="col-md-6 form-group">
                                    <label class="control-label">Max/Per Day</label>
                                    <input type="text" placeholder="Enter Value" class="form-control">
                                 </div>
                                  <div class="col-md-6 form-group">
                                    <label class="control-label">Max/Per Weekly</label>
                                    <input type="text" placeholder="Enter Value" class="form-control">
                                 </div> -->
                                    
                                </fieldset>
                            </form>
                            <div class="col-md-12 form-group">
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-add btn-sm" onclick="return processAdd()">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEmployee" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                           <h3><i class="fa fa-plus m-r-5"></i> Edit EMPLOYEE </h3>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal" id="updateEmployeeForm">
                                    <fieldset>
                                        <div class="col-md-12 form-group">
                                            <label>Admin Name </label>
                                            <select class="form-control" name="role_id" id="role_id_edit" multiple>
                                            @foreach ($user as $users )
                                                <option value="{{$users->id}}">{{$users->name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <!-- <div class="form-group col-sm-12">
                                         <label>Admin Name <span class="required"> * </span></label>
                                         <select class="form-control" name="ConnectStatus" multiple>
                                             <option value="1">jitender</option>
                                             <option value="2">sagar</option>
                                         </select>
                                        </div> -->
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">Employee Name <span class="required text-danger"> * </span> </label>
                                          <input type="text" placeholder="Enter Employee Name" name="name" id="emp_name_edit" class="form-control">
                                       </div>

                                        <div class="col-md-6 form-group">
                                          <label class="control-label">Mobile Number <span class="required text-danger"> * </span> </label>
                                          <input type="text" placeholder="Enter Mobile Number" name="contact" id="contact_edit" class="form-control">
                                       </div>
                                        <!-- <div class="col-md-6 form-group">
                                          <label class="control-label">User Type</label>
                                          <input type="text" placeholder="" name="" id="user_type_edit" class="form-control">
                                       </div> -->
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">User Type  <span class="required text-danger"> * </span></label>
                                            <select class="form-control" name="user_type"  id="user_type_edit"  disabled>
                                                @foreach ($role as $roles )
                                                <option value="{{$roles->id}}">{{$roles->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                          <label class="control-label">Email Id  <span class="required text-danger"> * </span></label>
                                          <input type="text" placeholder="Enter Email Id" name="email" id="email_edit" class="form-control">
                                       </div>
                                        
                                        <div class="col-md-6 form-group">
                                          <label class="control-label">DOB <span class="required text-danger"> * </span></label>
                                          <input type="date" placeholder="Enter DOB" name="dob" id="dob_edit" class="form-control">
                                       </div>
                                        <div class="col-md-6 form-group">
                                          <label class="control-label">DOJ <span class="required text-danger"> * </span></label>
                                          <input type="date" placeholder="DOJ" name="doj" id="doj_edit"  class="form-control">
                                       </div>        
                                       <div class="col-md-6 form-group">
                                            <label class="control-label">Alternate Mobile Number </label>
                                            <input type="text" placeholder="Alternate Mobile Number" name="alternate_contact" id="alternate_contact_edit" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Designation Type <span class="required text-danger"> * </span></label>
                                            <select class="form-control" name="designation_id"  id="designation_id_edit">
                                                @foreach ($designation as $designations )
                                                <option value="{{$designations->id}}">{{$designations->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                          <label class="control-label">Profile Image  </label>
                                          <!-- <input type="file" class="form-control" disabled> -->
                                          <input type="file" class="form-control" id="profile_image_edit" name="file">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">Password</label>
                                          <input type="password" placeholder="Enter Password" name="password" id="password_edit" class="form-control">
                                          <input type="hidden" placeholder="Enter Password"  id="current_password" class="form-control">
                                       </div>
                                        <!-- <div class="col-md-6 form-group">
                                          <label class="control-label">Max/Per Day</label>
                                          <input type="text" placeholder="Enter Value" class="form-control">
                                       </div>
                                        <div class="col-md-6 form-group">
                                          <label class="control-label">Max/Per Weekly</label>
                                          <input type="text" placeholder="Enter Value" class="form-control">
                                       </div> -->
                                       
                                    </fieldset>
                                    <input type="hidden" id="employeeId" value="" name="employeeId">
                                    <input type="hidden" id="userId" value="" name="userId">
                                 </form>
                                 <div class="col-md-12 text-right form-group">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                    <button id="updateItemutton" class="btn btn-add btn-sm">Update Employee</button>
                                </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>

@endsection
@push('custom-scripts')
<script>

function submitAddForm(isEdit = false) {
   //return true;
   processAdd () 
    // return validateForm();
}

function editEmployee(id) {
    $('#editEmployee').modal({
        show: 'true'
    }); 
    getDataForEdit(id);
}


function validateForm(isEdit=false) {
    let isValid = true;
    let validationMessage = "<b>Please follow below instruction before submitting form.</b><ul>";
    const role_id = (isEdit)?$("#role_id_edit").val():$("#role_id").val();
    const emp_name = (isEdit)?$("#emp_name_edit").val():$("#emp_name").val();
    const contact = (isEdit)?$("#contact_edit").val():$("#contact").val();
    const contactAlternate = (isEdit)?$("#alternate_contact_edit").val():$("#alternate_contact").val();
    const userType = (isEdit)?$("#user_type_edit").val():$("#user_type").val();
    const email = (isEdit)?$("#email_edit").val():$("#email").val();
    const password = (isEdit)?$("#password_edit").val():$("#password").val();
    const dob = (isEdit)?$("#dob_edit").val():$("#dob").val();
    const doj = (isEdit)?$("#doj_edit").val():$("#doj").val();
    // if(role_id == null || role_id?.length < 1) {
    //     validationMessage += `<li>Please select an admin. </li>`; 
    //     isValid=false;
    // }
    if(emp_name == null || emp_name =="") {
        isValid=false;
        validationMessage += `<li>Please fill employee name. </li>`; 
        
    }
    console.log("--contact--",contact);
    if(contact == null || contact =="") {
        console.log("No Mobile*************")
        validationMessage += `<li>Please fill mobile number. </li>`; 
        isValid=false;
    }
    else if(!(contact == null || contact =="")) {
        const isContactValid = isValidCotact(contact);
        console.log("##########isContactValid############",isContactValid);
        if(!isContactValid) {
            validationMessage+=`<li>Please fill valid mobile number. </li>`;
            isValid=false;
        }
    }
   
    if(email == null || email ==  "") {
        validationMessage += `<li>Please fill email field. </li>`; 
        isValid=false;
    }
    else if(!(email == null || email ==  "") ) {
        const isEmailValid = !isValidEmail(email);
        if(isEmailValid) {
            console.log();
            validationMessage += `<li>Please fill valid email Id. </li>`; 
            isValid=false;
        }
    }
    if(!(contactAlternate == null || contactAlternate =="")) {
        const isAlterNateContactValid = isValidCotact(contactAlternate);
        console.log("##########isAlterNateContactValid############",isAlterNateContactValid);
        if(!isAlterNateContactValid) {
            validationMessage+=`<li>Please fill valid alternate mobile number. </li>`;
            isValid=false;
        }
    }

    if((password ==0 || password == null) && !isEdit) {
        validationMessage += `<li>Please fill password field. </li>`; 
        isValid=false;
    } 

    if(dob ==0 || dob == null) {
        validationMessage += `<li>Please fill DOB field. </li>`; 
        isValid=false;
    } 
    if(doj ==0 || doj == null) {
        validationMessage += `<li>Please fill DOJ field. </li>`; 
        isValid=false;
    } 

    if(!isValid) {
        bootbox.alert(validationMessage);
        toastr.error( `${validationMessage}`);
    }
    return isValid;
}


function getDataForEdit(id) {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#employeeId").val(id);
    $.ajax({
        /* the route pointing to the post function */
        url: '/employee/edit',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
        data: {
            _token: CSRF_TOKEN,
            'employeeId': id
        },
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            const employee = data.employee;
            const user = data.user;
            $("#emp_name_edit").val(employee.name);
            $("#contact_edit").val(employee.contact);
            $("#email_edit").val(user.email);
            $("#dob_edit").val(employee.dob);
            $("#doj_edit").val(employee.doj);
            $("#alternate_contact_edit").val(employee.alternate_contact);
            $("#designation_id_edit").val(employee.designation_id);
            $("#userId").val(user.id);
        },
        failure: function (data) {
            toastr.error("Error occurred while processin!!");
        }
    });
}

$("#updateItemutton").click(function(){
    const isValid = validateForm(true);
    // return false;
    if(isValid) {
        const password = $("#password_edit").val();
        // alert("----password----"+password);
        if(password != null && password !="") {
            bootbox.confirm("You have entered some value in password field, Do you really want to change the password?", function(confirm){
                if(confirm) {
                    processUpdate();
                }
            })
        }
        else {
            processUpdate();
        }
        
    }
});

function processUpdate () {
    validateForm(true);
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const employeeId = $("#employeeId").val();
    const userId = $("#userId").val();
    var form_data = new FormData($('#updateEmployeeForm')[0]);
    // alert("I am here"+employeeId+"----"+userId);
    $.ajax({
        /* the route pointing to the post function */
        url: `/employee/updateEmployee/${employeeId} `,
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
        }
    });

}



function processAdd () {
    const isValid = validateForm();
    if(isValid) {
        console.log("----I am going to add----");
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var form_data = new FormData($('#addEmployeeForm')[0]);
        console.log("---form_data-----",form_data);
        $.ajax({
            /* the route pointing to the post function */
            url: `/employee/createemployee`,
            type: 'POST',
            contentType: false,
            processData: false,
            /* send the csrf-token and the input to the controller */
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
            }
        }); 
    }
    

}



function showMessage (action="edit/update") {
    toastr.error( `You are not allowed to ${action} designation!`);
}
</script>
@endpush