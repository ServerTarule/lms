@extends('layout.app')
@section('title', 'Holidays')
@section('subtitle', 'List of Holidays')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd ">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Holidays</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                            <span class="text-danger"><i  style="" class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add centers.  </i></span>
                            <a class="btn btn-exp btn-sm" onclick="return showMessage()"  disabled>
                                <i sclass="fa fa-plus"></i> Add Holiday
                            </a>
                        @else
                            <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addHoliday" {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }} >
                                <i sclass="fa fa-plus"></i> Add Holiday
                            </a> 
                        @endif
                        {{-- <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addHoliday"><i class="fa fa-plus"></i> Add Holiday</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="info">
                                <th>S. No.</th>
                                <th>Holiday Name</th>
                                <th>Date</th>
                                <th>Created Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($holidays as $holiday)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $holiday->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($holiday->day)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($holiday->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <!-- <a data-toggle="modal" data-target="#edititem" onclick="editHoliday({{$holiday->id}})" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a> -->
                                        <a onclick="return editHoliday({{ $holiday->id }})" role="button" class="btn btn-xs btn-success btn-flat show_confirm" {{ (isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1) ? ' disabled' : '' }}>
                                            <i class="fa fa-edit" title='Edit'></i>
                                        </a>
                                        {{-- <a onclick="return editHoliday({{ $holiday->id }})" class="btn-xs btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a> --}}
                                    </td>
                                    <td>
                                        <a href="#" id="deleteHoliday" onclick="deleteHoliday( {{ $holiday->id }})" class="btn btn-xs btn-danger btn-flat show_confirm" {{ (isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1) ? ' disabled' : '' }}>
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        {{-- <a href="#" id="deleteHoliday" onclick="deleteHoliday({{$holiday->id}})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a> --}}
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addHoliday" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Add Holiday</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" id="addItemForm" method="POST">
                                @csrf
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-8 form-group">
                                        <label class="control-label">Holiday Name</label>
                                        <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Date</label>
                                        <input type="date" id="day" name="day" placeholder="dd/mm/yyyy" class="form-control">
                                    </div>
                                    
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <button type="button" class="btn btn-danger btn-sm"data-dismiss="modal">Cancel</button>
                                <button class="btn btn-add btn-sm"  id="addHolidayButton" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editHolidayPupup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-pencil m-r-5"></i> Edit Holiday</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal"  method="POST" >
                                @csrf
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-8 form-group">
                                        <label class="control-label">Holiday Name</label>
                                        <input type="text" id="name-edit" name="name" placeholder="Enter Name" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Date</label>
                                        <input type="date" id="day-edit" name="day" placeholder="dd/mm/yyyy" class="form-control">
                                    </div>
                                    
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <input type="hidden" name="holidayId" id="holidayId" value="">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-add btn-sm" id="updateItemButton" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')

<script type="text/javascript">
   function validateForm(edit=false) {
        const name = (edit)?$("#name-edit").val().trim():$("#name").val().trim();
        const day = (edit)?$("#day-edit").val().trim():$("#day").val().trim();
        if(!name) {
            toastr.error("Holicay name field is required!");
            return false;
        }
        else if(!day) {
            toastr.error("Date field is required!");
            return false;
        }
        else {
            return true;
        }
        alert("Inside  validation");
    
    }
    $("#addHolidayButton").click(function(){
        processAdd()
    });

    function processAdd () {
        const isValid = validateForm();
        if(isValid) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/holidays/store',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    'name':$("#name").val(),
                    'day':$("#day").val()
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if(data.error) {
                        toastr.error(data.message);
                    }
                    else {
                        toastr.success(data.message);
                        $("#addItemForm")[0].reset()
                        $('#addHoliday').modal('toggle');
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
    function editHoliday(holidayId) {
        const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
        if(!editPermission) {
            toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
            return false;
        }
        else {
            getHolidayData(holidayId);
        }
    }

    function getHolidayData(holidayId) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#holidayId").val(holidayId);
        $.ajax({
            /* the route pointing to the post function */
            url: '/holidays/edit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            data: {
                _token: CSRF_TOKEN,
                'holidayId': holidayId
            },
            // data: $(this).serialize(),
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                const holiday = data.holiday;
                $("#name-edit").val(holiday?.name);
                $("#day-edit").val(holiday?.day);
                $('#editHolidayPupup').modal({
                    show: 'true'
                }); 
            },
            failure: function (data) {
                toastr.error("Error occurred while processin!!");
            },
            error:function(xhr, status, error) {
                const resText = JSON.parse(xhr.responseText);
                toastr.error( resText.message);
            },
        });
    }
    $("#updateItemButton").click(function(){
        updateHoliday()
    });

    function updateHoliday() {
        validateForm(1);
        const holidayId = $("#holidayId").val();
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function  /doctors/update/{id}*/
            url: `/holidays/update/${holidayId} `,
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'name':$("#name-edit").val(),
                'day':$("#day-edit").val()
            },
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
    function processDeleteHoliday(id) {
        bootbox.confirm("Are you sure you want to delete this holiday?", function (resp){
            if(resp) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/holidays/destroy',
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
                        window.location.href = "/holidays";
                    },
                    failure: function (data) {
                        console.log(data);
                    },
                    error:function(xhr, status, error) {
                        const resText = JSON.parse(xhr.responseText);
                        toastr.error( resText.message);
                    },
                });
            }
            else{
                return;
            }
        })
    }
    function deleteHoliday(id) {
        const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
        if(!editPermission) {
            toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
            return false;
        }
        else {
            processDeleteHoliday(id);
        }
    }
   
</script>
@endpush