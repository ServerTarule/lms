@extends('layout.app')
@section('title', 'View Employee Leaves')
@section('subtitle', 'View Employee Leaves')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>View Employee Leaves</h4>
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
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover defaultDataTable">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>

                                    <th scope="col">
                                        <a> Employee Id.</a>
                                    </th>

                                    <th scope="col">
                                        <a>Employee Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Employee user name (Email ID)</a>
                                    </th>
                                    <th scope="col">
                                        <a>Employee role</a>
                                    </th>
                                    {{-- <th scope="col">
                                        <a>Upcoming Leaves</a>
                                    </th> --}}

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
                                        <td>{{ $employee->id  }}</td>
                                        <td>{{ $employee->name  }}</td>
                                        <td>{{ $employee->user->email  }}</td>
                                        <td>{{ $employee->user->role->name  }}</td>
                                        {{-- <td></td> --}}
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
                                                <label>Employee Name <span class="required text-danger"> * </span></label>
                                                <select class="form-control" name="employeeid" id="employeeid" required>
                                                    <option value="">-- Select Employee --</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">From <span class="required text-danger"> * </span></label>
                                          <input type="datetime-local" placeholder="From" name="from" id="from_date" class="form-control" required>
                                       </div>
                                         <div class="col-md-6 form-group">
                                          <label class="control-label">To <span class="required text-danger"> * </span></label>
                                          <input type="datetime-local" placeholder="To" name="to" id="to_date" class="form-control" required>
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <label class="control-label">Type <span class="required text-danger"> * </span></label>
                                          <select class="form-control" name="type" id="leave_type"  required>
                                             <option value=""> --Select Type--</option>
                                             <option>Personal Leave</option>
                                             <option>Sick Leave</option>
                                          </select>
                                       </div>
                                        <div class="col-md-12 form-group">
                                          <label class="control-label">Comment <span class="required text-danger"> * </span></label>
                                          <textarea placeholder="Comment" name="comment" id="leave_comment"  class="form-control" required></textarea>
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
        const isValid = validateForm();
        // alert("isValid=="+isValid); 
        if(isValid) {
            console.log("----I am goinwwwwwwwwwwwwwwwsg to add----");
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
        else {

        }
    }


    function validateForm(isEdit=false) {
        // alert('eeeee');
        let isValid = true;
        let validationMessage = "<b>Please follow below instruction before submitting form.</b><ul>";
        const employee_name = (isEdit)?$("#employeeid_edit").val():$("#employeeid").val();
        const from_date = (isEdit)?$("#from_date_edit").val():$("#from_date").val();
        const to_date = (isEdit)?$("#to_date_edit").val():$("#to_date").val();
        const leave_type = (isEdit)?$("#leave_type_edit").val():$("#leave_type").val();
        const leave_comment = (isEdit)?$("#leave_comment_edit").val():$("#leave_comment").val();
        console.log("---employee_name--",employee_name);
        if(!employee_name || employee_name == null || employee_name == "") {
            validationMessage += `<li>Please select an employee. </li>`; 
            isValid=false;
        }

        if(from_date == null || !from_date) {
            validationMessage += `<li>Please select from date. </li>`; 
            isValid=false;
        }
        if(to_date == null || !to_date) {
            validationMessage += `<li>Please select to date. </li>`; 
            isValid=false;
        }
        if(leave_type == null || leave_type =="") {
            console.log("No Mobile*************")
            validationMessage += `<li>Please select leave type. </li>`; 
            isValid=false;
        } 

        if(!leave_comment || leave_comment == null || leave_comment == "") {
            validationMessage += `<li>Please fill comment. </li>`; 
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