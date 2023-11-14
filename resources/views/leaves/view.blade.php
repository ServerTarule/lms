@extends('layout.app')
@section('title', 'View Employee Leaves')
@section('subtitle', 'List View')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Leaves</h4>
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
                    <a class="btn btn-exp btn-sm" href="/leaves">< Back</a>
                </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead>
                                    <tr class="info">
                                        <th>S. No.</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>No. Of Leaves</th>
                                        <th>Created Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                 </thead>
                            <tbody>
                                @foreach ($leaves as $leave)
                                    <tr>
                                        <td>{{ $leave->id }}</td>
                                        <td>{{ $leave->start_time }}</td>
                                        <td>{{ $leave->end_time }}</td>
                                        <td>{{ $leave->type }}</td>
                                        <td>{{ $leave->comment }}</td>
                                        {{-- {{\Carbon\Carbon::parse($action->created_at)->format('d/m/Y')}} --}}
                                        <td>
                                            @php
                                                $years = gmdate(\Carbon\Carbon::parse($leave->end_time)->diff(\Carbon\Carbon::parse($leave->start_time))->format("%y"));
                                                $months = gmdate(\Carbon\Carbon::parse($leave->end_time)->diff(\Carbon\Carbon::parse($leave->start_time))->format("%m"));
                                                $days = gmdate(\Carbon\Carbon::parse($leave->end_time)->diff(\Carbon\Carbon::parse($leave->start_time))->format("%d"));
                                                $hours = gmdate(\Carbon\Carbon::parse($leave->end_time)->diff(\Carbon\Carbon::parse($leave->start_time))->format("%h"));
                                                $leaveCount = $days;
                                                if($hours >= 4 && $hours < 8) {
                                                    // echo "$days.5 Days";
                                                    $leaveCount =  $days + .5 ;
                                                }
                                                else if($hours > 8)  {
                                                    $leaveCount = $days +1;
                                                    // echo $days ." Days";
                                                }
                                                $leaveStr = $leaveCount." Days";
                                                if($months > 0) {
                                                    $leaveStr = $months." Month(s) ".$leaveStr;
                                                }
                                                if($years > 0) {
                                                    $leaveStr = $years." Years(s) ".$leaveStr;
                                                }
                                                echo $leaveStr;
                                            @endphp
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($leave->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                                {{-- <a data-toggle="modal" data-target="#edititem" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a> --}}
                                            @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                                {{-- @if($userCrudPermissions['edit_permission'])  --}}
                                                <button  onclick="return showMessage(1)" class="btn btn-xs btn-success btn-flat show_confirm disabled"> <i class="fa fa-pencil"></i>  </button>
                                            @else
                                                <button onclick="return editLeave({{$leave->id}})" class="btn btn-xs btn-success btn-flat show_confirm"> <i class="fa fa-pencil"></i>  </button>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="#" id="deleteLeave" onclick="deleteLeave({{ $leave->id }}, {{ $leave->employee_id }})" class="btn-xs btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                            </a> --}}
                                            @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                            {{-- @if($userCrudPermissions['delete_permission'])  --}}
                                                <button href="#" onclick="showMessage()" class="btn btn-xs btn-danger btn-flat show_confirm disabled">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>                         
                                            @else
                                                <button id="deleteLeave" onclick="deleteLeave({{ $leave->id }}, {{ $leave->employee_id }})" class="btn btn-xs btn-danger btn-flat show_confirm">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>                                         
                                            @endif
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
    <div class="modal fade" id="editLeaveModel" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                           <h3><i class="fa fa-plus m-r-5"></i> Add Leave</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                               <div class="col-md-12">
                                  <form class="form-horizontal" id="leaveupdateform"  >
                                      @csrf
                                     <fieldset>
                                            <div class="col-md-12 form-group">
                                                <label>Employee Name</label>
                                                <input type="text" id="employee-mame" placeholder="Employee Name" class="form-control" readonly>
                                                <span class="text-danger"><i class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="Employee name can't be changed for alredy applied leave, so it is made read only."> Name can't be changed.  </i></span>
                                            </div>
                                            <div class="col-md-6 form-group">
                                            <label class="control-label">From</label>
                                            <input type="datetime-local" placeholder="From" id="leave-from" name="from" class="form-control">
                                            </div>
                                          <div class="col-md-6 form-group">
                                           <label class="control-label">To</label>
                                           <input type="datetime-local" placeholder="To" id="leave-to" name="to" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                           <label class="control-label">Type</label>
                                           <select class="form-control" id="leave-type" name="type">
                                              <option selected disabled> --Select Type--</option>
                                              <option>Personal Leave</option>
                                              <option>Sick Leave</option>
                                           </select>
                                        </div>
                                         <div class="col-md-12 form-group">
                                           <label class="control-label">Comment</label>
                                           <textarea placeholder="Comment" id="leave-comment" name="comment" class="form-control"></textarea>
                                        </div>
                                        <input type="hidden" id="employeeid" value="" name="employeeid">
                                        <input type="hidden" id="leaveid" value="" name="leaveid">
                                     </fieldset>
                                  </form>
                                  <div class="col-md-12 form-group">
                                     <div>
                                        
                                        
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" >Cancel</button>
                                        <button type="submit" id="updateLeaveButton" class="btn btn-add btn-sm">Save</button>
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
function showMessage() {
    toastr.error("You are not allowed to perform this action!")
}
function deleteLeave(id, employeeid) {
    bootbox.confirm("Are you sure you want to delete this leave?", function (confirmed) {
        if(confirmed){
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
                error:function(xhr, status, error) {
                    console.log("error",xhr, xhr.responseText,status,error);
                    toastr.error( xhr.responseText);
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            return;
        }
    })    
}

function editLeave(leaveId) {
    const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
    if(!editPermission) {
        toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
        return false;
    }
    else {
        $('#editLeaveModel').modal({
            show: 'true'
        }); 
        getDataForEdit(leaveId);
    }
}


function getDataForEdit(leaveId) {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#leaveid").val(leaveId);
    $.ajax({
        /* the route pointing to the post function */
        url: `/leaves/getById/${leaveId}`,
        type: 'GET',
        /* send the csrf-token and the input to the controller */
        // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            const leaveDetails = data.leave;
            const employeeDetails = data.employee;
            $("#employeeid").val(employeeDetails.id);
            $("#employee-mame").val(employeeDetails.name);
            $("#leave-from").val(leaveDetails.start_time);
            $("#leave-to").val(leaveDetails.end_time);
            $("#leave-type").val(leaveDetails.type);
            $("#leave-comment").val(leaveDetails.comment);
        },
        failure: function (data) {
            toastr.error("Error occurred while processin!!");
        },
        error:function(xhr, status, error) {
            const resText = JSON.parse(xhr.responseText);
            toastr.error( resText.message);
        }
    });
}

$("#updateLeaveButton").click(function(){
    const isValid = true;//validateForm(true);
    // return false;
    if(isValid) {
        processUpdate();
    }
});

function processUpdate () {
    // validateForm(true);
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const employeeId = $("#employeeid").val();
    const leadId = $("#leaveid").val();
    var form_data = new FormData($('#leaveupdateform')[0]);
    // alert("I am here"+employeeId+"----"+userId);
    // form_data.append("employeeid",employeeId);
    $.ajax({
        /* the route pointing to the post function */
        url: `/leaves/updateleave/${leadId} `,
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



</script>
@endpush