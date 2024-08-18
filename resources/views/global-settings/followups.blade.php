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
                                        <a>Id</a>
                                    </th>
                                    <th scope="col">
                                        <a>Follow Up Number</a>
                                    </th>
                                    <th scope="col">
                                        <a>Follow Up Desc</a>
                                    </th>
                                    <th scope="col">
                                        <a>Follow Up Interval</a>
                                    </th>
                                    <th scope="col">
                                        <a>Follow Up Type</a>
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
                            @foreach ($followupsSettings as $followupsSetting)
                                <tr>
                                    <td>{{ $followupsSetting->id }}</td>
                                    <td>{{ $followupsSetting->follow_up_sequence }}</td>
                                    <td>{{ $followupsSetting->follow_up_desc }}</td>
                                    <td>{{ $followupsSetting->follow_up_interval }}</td>
                                    <td>{{ $followupsSetting->follow_up_type ==1 ?'Promotional' : 'Non Promotional'}}</td>
                                    <td>
                                        <a data-toggle="modal" onclick="return editFollowupsSetting({{ $followupsSetting->id }})" class="btn btn-xs btn-success btn-flat show_confirm">
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
                    <h3><i class="fa fa-pencil m-r-5"></i>Edit Follo Up Setting</h3>
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
                                        <label class="control-label" >Follow Up Number &nbsp; &nbsp;</label>
                                        <input type="number"  class="form-control" id="follo_up_no" name="follo_up_no" max="5">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" >Follow Up Description  &nbsp; &nbsp;</label>
                                        <input type="text" class="form-control" name="follo_up_desc" id="follo_up_desc">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" >Follow Up Type  &nbsp; &nbsp;</label>
                                        {{-- <input type="text"  name="follo_up_desc" id="follo_up_desc"  readonly disabled> --}}
                                        <select  onchange="changed(this)"  class="form-control city-dropdown" name="follow_up_type"  id="follow_up_type">
                                            <option value="1">Prootional</option>
                                            <option value="2">Non Prootional</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" >Follow Up Interval  &nbsp; &nbsp;</label>
                                        <input type="number" class="form-control" name="follo_up_interval" id="follo_up_interval" max="30" >
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
    function changed(element) {
        console.log("value==="+element,"====",element.id,"-=-",$("#"+element.id).val());
    }
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


    function editFollowupsSetting(id) {
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
            url: '/global-settings/followup/edit/'+id,
            type: 'GET',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            success: function (data) {
                
                const followupsSetting = data.followupsSetting;
                const follow_up_type = data.followupsSetting.follow_up_type;
                $("#follo_up_no").val(followupsSetting.follow_up_sequence);
                $("#follo_up_desc").val(followupsSetting.follow_up_desc);
                console.log("Setting follow_up_type to:", followupsSetting.follow_up_type);
                $('#follow_up_type').val(follow_up_type).change();
                // $('#follow_up_type option').each(function() {
                //     console.log($(this).val());
                // });

            // Set the dropdown value and log the result
            $("#follow_up_type option").val(followupsSetting.follow_up_type).change();
            console.log("Dropdown value after setting:", $("#follow_up_type").val());

                //                $("#follow_up_type").val(followupsSetting.follow_up_type).change();
                $("#follo_up_interval").val(followupsSetting.follow_up_interval);
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