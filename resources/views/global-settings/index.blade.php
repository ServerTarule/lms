@extends('layout.app')
@section('title', 'Manage Templates')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Global Settings</h4>
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
                    <div class="table-responsive">
                        <table id="userListTable" class="table table-bordered table-striped table-hover defaultDataTable">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Id</a>
                                    </th>
                                    <th scope="col">
                                        <a>Setting Key</a>
                                    </th>
                                    <th scope="col">
                                        <a>Setting Value</a>
                                    </th>
                                    <th scope="col">
                                        <a>Setting Unit</a>
                                    </th>
                                    <th scope="col">
                                        <a>Created By</a>
                                    </th>
                                    <th scope="col">
                                        <a>Created At</a>
                                    </th>
                                    <th scope="col">
                                        <a>Modefied By</a>
                                    </th>
                                    <th scope="col">
                                        <a>Modefied At</a>
                                    </th>
                                    <th scope="col">
                                        <a>Edit</a>
                                    </th>
                                    {{-- <th scope="col">
                                        <a>Delete</a>
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($globalSettings as $globalSetting)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $globalSetting->id }}</td>
                                    <td>{{ $globalSetting->setting_key }}</td>
                                    <td>{{ $globalSetting->setting_value }}</td>
                                    <td>{{ $globalSetting->setting_unit }}</td>
                                    <td>
                                        {{ $globalSetting->created_by_name }}
                                    </td>
                                    <td>
                                        {{ $globalSetting->created_at }}
                                    </td>
                                    <td>
                                        {{ $globalSetting->modified_by_name }}
                                    </td>
                                    <td>
                                        {{ $globalSetting->updated_at }}
                                    </td>
                                    <td>
                                        <a data-toggle="modal" onclick="return editEmployee({{ $globalSetting->id }})" class="btn btn-xs btn-success btn-flat show_confirm">
                                            <i class="fa fa-edit"></i>
                                        </a> 
                                    </td>
                                    {{-- <td>Delete</td> --}}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSettingPopUp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-pencil m-r-5"></i>Edit Setting</h3>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-around">
                        <div class="col-md-4  bg-primaryd">
                            &nbsp;
                        </div>
                        <div class="col-md-4  text-warning">
                            <i class="fa fa-exclamation-triangle " aria-hidden="true"> &nbsp;Please fill all mandatory<span><sup class="text-danger">*</sup></span> fields</i>
                       </div>
                        <div class="col-md-4  bg-primaryd">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <form class="form-horizontal" id="updateEmployeeForm"> --}}
                            <form class="form-horizontal" id="updateSettingsForm"  method="POST">
                                @csrf
                                <fieldset>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" >Setting key &nbsp; &nbsp;</label>
                                        <input type="text" id="setting_key" name="setting_key" readonly disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" >Setting Unit  &nbsp; &nbsp;</label>
                                        <input type="text"  name="setting_unit" id="setting_unit"  readonly disabled>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" >Setting Value &nbsp; &nbsp;</label>
                                        <input type="text"   name="setting_value"  id="setting_value">
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 form-group text-right">
                                <input type="hidden" name="id" id="setting_id" value="">

                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="updateItemButton"  class="btn btn-add btn-sm">Update Setting</button>
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
    function showMessage(isEdit=false) {
        if(isEdit) {
            const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
            if(!editPermission) {
                toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
                return false;
            }
        }
        else {
            const addPermission  = "{{$userCrudPermissions['add_permission']}}";
            if(!addPermission) {
                toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
                return false;
            }
        }
    }


    function editEmployee(id) {
        $('#editSettingPopUp').modal({
            show: 'true'
        }); 
        getDataForEdit(id);
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
            url: '/global-settings/edit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            data: {
                _token: CSRF_TOKEN,
                'settingId': id
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                const setting = data.setting;
                $("#setting_key").val(setting.setting_key);
                $("#setting_value").val(setting.setting_value);
                $("#setting_unit").val(setting.setting_unit);
                $("#setting_id").val(setting.id);
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
$("#updateItemButton").click(function(){
    processUpdate();
})
function processUpdate () {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const settingId = $("#setting_id").val();
    console.log("----settingId---",settingId);
    var form_data = new FormData($('#updateSettingsForm')[0]);
    // alert("I am here"+employeeId+"----"+userId);
    $.ajax({
        /* the route pointing to the post function */
        url: `/global-settings/update-settings/${settingId} `,
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