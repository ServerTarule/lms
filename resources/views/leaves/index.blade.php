@extends('layout.app')
@section('title', 'Employee Leaves')
@section('subtitle', 'List of Leaves')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Employee Leaves</h4>
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
                        @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                            <span class="text-danger"><i class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add employee(s).  </i></span>
                            &nbsp;
                            <button type="button" class="btn btn-exp btn-sm disabled" onclick="return showMessage()">
                                <i class="fa fa-plus"> Add Leave</i>
                            </button>
                        @else
                            <a class="btn btn-exp btn-sm {{ (!$userCrudPermissions['add_permission']) ? ' disabled' : '' }}" data-toggle="modal" data-target="#additem">
                                <i class="fa fa-plus"></i>
                                Add Leave
                            </a>  
                            {{-- <button type="submit" class="btn btn-add btn-sm" onclick="return processAdd()">Save</button> --}}
                        @endif
                        
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover ">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Employee Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Upcoming Leaves</a>
                                    </th>

                                    <th scope="col">
                                        <a>List View</a>
                                    </th>
                                    <th scope="col">
                                        <a>Calender View</a>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->name  }}</td>
                                        <td></td>
                                        <td>
                                            <a href="/leaves/{{ $employee->id }}" class="btn-xs btn-success"> <i class="fa fa-eye"></i>  </a>
                                        </td>
                                        <td>
                                            <a href="/leaves/calendar/{{ $employee->id}}" class="btn-xs btn-success"> <i class="fa fa-eye"></i>  </a>
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
                           <h3><i class="fa fa-plus m-r-5"></i> Add Leave</h3>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal" id="leaveaddform"  >
                                     @csrf
                                    <fieldset>
                                            <div class="col-md-12 form-group">
                                                <label>Employee Name</label>
                                                <select class="form-control" name="employeeid" id="employeeid">
                                                    <option>-- Select Employee --</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">From</label>
                                          <input type="datetime-local" placeholder="From" name="from" class="form-control">
                                       </div>
                                         <div class="col-md-6 form-group">
                                          <label class="control-label">To</label>
                                          <input type="datetime-local" placeholder="To" name="to" class="form-control">
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <label class="control-label">Type</label>
                                          <select class="form-control" name="type">
                                             <option selected disabled> --Select Type--</option>
                                             <option>Personal Leave</option>
                                             <option>Sick Leave</option>
                                          </select>
                                       </div>
                                        <div class="col-md-12 form-group">
                                          <label class="control-label">Comment</label>
                                          <textarea placeholder="Comment" name="comment" class="form-control"></textarea>
                                       </div>
                                       
                                    </fieldset>
                                 </form>
                                 <div class="col-md-12 form-group">
                                    <div>
                                       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" >Cancel</button>
                                       <button type="submit" onclick="return addleave()" class="btn btn-add btn-sm">Save</button>
                                    </div>
                                 </div>
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
//addleave
//action="/leaves/store"
    function addleave() {
        const isValid = true;//validateForm();
        if(isValid) {
            console.log("----I am going to add----");
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form_data = new FormData($('#leaveaddform')[0]);
            console.log("---form_data-----",form_data);
            $.ajax({
                /* the route pointing to the post function */
                url: `/leaves/storeleaves`,
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
                            //  location.reload();
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

    function validateForm(isEdit=false) {
        let isValid = true;
        let validationMessage = "<b>Please follow below instruction before submitting form.</b><ul>";
        const admin_name = (isEdit)?$("#admin_name_edit").val():$("#admin_name").val();
        const role_id = (isEdit)?$("#role_id_edit").val():$("#role_id").val();
        const emp_name = (isEdit)?$("#emp_name_edit").val():$("#emp_name").val();
        const contact = (isEdit)?$("#contact_edit").val():$("#contact").val();
        const contactAlternate = (isEdit)?$("#alternate_contact_edit").val():$("#alternate_contact").val();
        const userType = (isEdit)?$("#user_type_edit").val():$("#user_type").val();
        const email = (isEdit)?$("#email_edit").val():$("#email").val();
        const password = (isEdit)?$("#password_edit").val():$("#password").val();
        const dob = (isEdit)?$("#dob_edit").val():$("#dob").val();
        const doj = (isEdit)?$("#doj_edit").val():$("#doj").val();

        // if(admin_name == null || admin_name?.length < 1) {
        //     validationMessage += `<li>Please select an admin. </li>`; 
        //     isValid=false;
        // }

        if(role_id == null ||role_id == 0 || role_id?.length < 1) {
            validationMessage += `<li>Please select an user type. </li>`; 
            isValid=false;
        }
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

</script>
@endpush