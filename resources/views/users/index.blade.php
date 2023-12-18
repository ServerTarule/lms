@extends('layout.app')
@section('title', 'Manage Templates')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Users</h4>
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
                        {{-- @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                            <span class="text-danger"><i  style="" class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add centers.  </i></span>
                            <a class="btn btn-exp btn-sm" onclick="return showMessage()" {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }} >
                                <i sclass="fa fa-plus"></i> Add User
                            </a>
                        @else
                            <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addTemplate" {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }} >
                                <i sclass="fa fa-plus"></i>Add User
                            </a> 
                        @endif --}}
                        
                    </div>
                    <div class="table-responsive">
                        <table id="userListTable" class="table table-bordered table-striped table-hover defaultDataTable">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Email</a>
                                    </th>
                                    <th scope="col">
                                        <a>Profile Photo</a>
                                    </th>
                                    <th scope="col">
                                        <a>User Role</a>
                                    </th>
                                    <th scope="col">
                                        <a>Created Date</a>
                                    </th>
                                    {{-- <th scope="col">
                                        <a>Edit</a>
                                    </th> --}}
                                    {{-- <th scope="col">
                                        <a>Status</a>
                                    </th>              --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->profile_img)
                                            <img src="{{$user->profile_img}}" height="40px" width="40px" />
                                        @elseif (!$user->profile_img || $user->profile_img =='user.png')
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                                    {{-- <td> --}}
                                        <!-- <a data-toggle="modal" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a> -->
                                        {{-- <a onclick="return editTemplate({{ $template->id }})" class="btn-xs btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a> --}}
                                        {{-- <a onclick="return editUser({{ $user->id }})" role="button" class="btn btn-xs btn-success btn-flat show_confirm" {{ (isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1) ? ' disabled' : '' }}>
                                            <i class="fa fa-edit" title='Edit'></i>
                                        </a> --}}
                                    {{-- </td> --}}
                                    {{-- <td>
                                        @if ((isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1))
                                            <label class="switch disabled">
                                                <input  value="{{ $user->id }}" type="hidden">
                                                <input class=" disabled"{{$user->status === 1 ? 'checked':''}} type="checkbox" value="{{ $user->status }}" onchange="showMessage();" @checked( $user->status === 'true') />
                                                <span class="slider round"></span>
                                            </label>
                                        @else
                                            <label class="switch">
                                                <input id="action_input_{{ $user->id }}" value="{{ $user->status }}" type="hidden">
                                                <input id="action_toggle_{{ $user->id }}" {{$user->status == 1 ? 'checked':''}} type="checkbox" value="{{ $user->status }}" onchange="toggleUserStatus(this, {{ $user->id }});" @checked( $user->status === 'true') />
                                                <span class="slider round"></span>
                                            </label>
                                        @endif 
                                    </td> --}}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTemplate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i>ADD TEMPLATE</h3>
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
                            <form class="form-horizontal" id="addItemForm" method="POST">
                                @csrf
                                <fieldset>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Type<sup class="text-danger font-weight-bold">*</sup></label>
                                        <select id="templateType" name="templateType" class="form-control">
                                            <option value="0">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Template<sup class="text-danger font-weight-bold">*</sup></label>
                                        <input type="text" id="templateName" name="templateName" placeholder="Template" class="form-control">
                                    </div>
                                    <div id="templateSubjectDiv" class="col-md-12 form-group">
                                        <label class="control-label">Subject<sup class="text-danger font-weight-bold">*</sup></label>
                                        <input type="text" id="templateEmailSubject" name="templateEmailSubject" placeholder="Please type here.." class="form-control">
                                    </div>
                                    <div id="templateMessageDiv" class="col-md-12 form-group">
                                        <label class="control-label">WhatsApp Template Body<sup class="text-danger font-weight-bold">*</sup></label>
                                        <textarea class="form-control" id="templateMessage" name="templateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div id="templateEmailDiv" class="col-md-12 form-group">
                                        <label class="control-label">Email Template Body<sup class="text-danger font-weight-bold">*</sup></label>
                                        <textarea class="ckeditor form-control" id="templateEmailBody" name="templateEmailBody" placeholder="Please type here.."></textarea>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 form-group text-right">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="addItemButton"  class="btn btn-add btn-sm">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTemplatePopUp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-pencil m-r-5"></i>Edit TEMPLATE</h3>
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
                            <form class="form-horizontal" method="POST">
                                @csrf
                                <fieldset>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Type<sup class="text-danger font-weight-bold">*</sup></label>
                                        <select id="templateTypeEdit" name="templateTypeEdit" class="form-control">
                                            <option value="0">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Template<sup class="text-danger font-weight-bold">*</sup></label>
                                        <input type="text" id="templateNameEdit" name="templateName" placeholder="Template" class="form-control">
                                    </div>
                                    <div id="templateSubjectDivEdit" class="col-md-12 form-group">
                                        <label class="control-label">Subject<sup class="text-danger font-weight-bold">*</sup></label>
                                        <input type="text" id="templateEmailSubjectEdit" name="templateEmailSubject" placeholder="Please type here.." class="form-control">
                                    </div>
                                    <div id="templateMessageDivEdit" class="col-md-12 form-group">
                                        <label class="control-label">WhatsApp Template Body<sup class="text-danger font-weight-bold">*</sup></label>
                                        <textarea class="form-control" id="templateMessageEdit" name="templateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div id="templateEmailDivEdit" class="col-md-12 form-group">
                                        <label class="control-label">Email Template Body<sup class="text-danger font-weight-bold">*</sup></label>
                                        <textarea class="ckeditor form-control" id="templateEmailBodyEdit" name="templateEmailBody" placeholder="Please type here.."></textarea>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 form-group text-right">
                                <input type="hidden" name="templateId" id="templateId" value="">

                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="updateItemButton"  class="btn btn-add btn-sm">Update Template</button>
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
    $("#templateSubjectDiv").hide();
    $("#templateEmailDiv").hide();
    $("#templateMessageDiv").hide();

    $('select[name="templateType"]').change(function() {
        console.log("---$(this).val()----",$(this).val());
        if($(this).val() === 'WhatsApp') {
            $("#templateMessageDiv").show();
            $("#templateSubjectDiv").hide();
            $("#templateEmailDiv").hide();
            CKEDITOR.instances.templateEmailBody.setData("");
            $("#templateEmailSubject").val("");
        }

        if($(this).val() === 'Email') {
            $("#templateMessageDiv").hide();
            $("#templateSubjectDiv").show();
            $("#templateEmailDiv").show();

            $("#templateMessage").val("")
        }
    });

    $('select[name="templateTypeEdit"]').change(function() {
        console.log("---$(this).val()esit----",$(this).val(),"---if condition---",$(this).val() === 'WhatsApp',"----else condition===",$(this).val() === 'WhatsApp');
        if($(this).val() === 'WhatsApp') {
            $("#templateMessageDivEdit").show();
            $("#templateSubjectDivEdit").hide();
            $("#templateEmailDivEdit").hide();
            $("#templateEmailSubjectEdit").val("");
        }

        if($(this).val() === 'Email') {
            $("#templateMessageDivEdit").hide();
            $("#templateSubjectDivEdit").show();
            $("#templateEmailDivEdit").show();
            $("#templateMessageEdit").val("")
            // CKEDITOR.instances.templateEmailBodyEdit.setData("");

        }
    });

    function validateForm(isEdit=false) {
        const templateType  = isEdit?$("#templateTypeEdit").val():$("#templateType").val();
        const templateName  = isEdit?$("#templateNameEdit").val():$("#templateName").val();
        const templateEmailSubject  = isEdit?$("#templateEmailSubjectEdit").val():$("#templateEmailSubject").val();
        const templateMessage  = isEdit?$("#templateMessageEdit").val():$("#templateMessage").val();
        const content = isEdit?CKEDITOR.instances.templateEmailBodyEdit.getData():CKEDITOR.instances.templateEmailBody.getData(); 
        if(templateType ==0) {
            
            toastr.error("Please select template type!");
            return false;
        }
        else if(templateName == "") {
            toastr.error("Please fill template name!");
            return false;
        }
        else if(templateType=="Email" && templateEmailSubject == "") {
            toastr.error("Please fill email template subject!");
            return false;
        }
        else if(templateType!="Email" && templateMessage == "") {
            toastr.error("Please fill whatsapp template field!");
            return false;
        }
        else if(templateType=="Email" && content == "") {
            toastr.error("Please fill email template body!");
            return false;
        }
        else {
            return true;
        }

    }
    
    $("#addItemButton").click(function(){
        // alert("I am here");
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
                url: '/templates/store',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    'templateName':$("#templateName").val(),
                    'templateType':$("#templateType").val(),
                    'templateEmailSubject':$("#templateEmailSubject").val(),
                    'templateEmailBody':CKEDITOR.instances.templateEmailBody.getData(),
                    'templateMessage':$("#templateMessage").val()
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
                        $('#addTemplate').modal('toggle');
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
                }
            });
        }
        
    }

    function editUser(templateId) {
        getTemplateData(templateId);
    }

    function getTemplateData(templateId) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#templateId").val(templateId);
        CKEDITOR.replace("templateEmailBodyEdit", {
            height: 100
        });
        CKEDITOR.instances.templateEmailBodyEdit.setData("");
        $("#templateMessageEdit").val(""); 
        $.ajax({
            /* the route pointing to the post function */
            url: '/templates/edit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            data: {
                _token: CSRF_TOKEN,
                'templateId': templateId
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                var templateObject = data?.template;//data?.template;
               if(templateObject?.type == "Email")
               {
                    $("#templateMessageDivEdit").hide();
                    $("#templateSubjectDivEdit").show();
                    $("#templateEmailDivEdit").show();
                    $("#templateTypeEdit").val(templateObject?.type);
                    $("#templateNameEdit").val(templateObject?.name);
                    $("#templateEmailSubjectEdit").val(templateObject?.subject);
                    const html =  data?.template?.message;
                    console.log("==html===",html);
                    CKEDITOR.instances.templateEmailBodyEdit.setData(html);
                    $("#templateMessageEdit").val(""); 
               }
               else {
                    $("#templateMessageDivEdit").show();
                    $("#templateSubjectDivEdit").hide();
                    $("#templateEmailDivEdit").hide();
                    $("#templateTypeEdit").val(templateObject?.type);
                    $("#templateNameEdit").val(templateObject?.name);
                    $("#templateMessageEdit").val(templateObject?.message);  
                    CKEDITOR.instances.templateEmailBodyEdit.setData("") 
               }
               
                $('#editTemplatePopUp').modal({
                    show: 'true'
                }); 
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
        updateTemplate()
    });

    function updateTemplate() {
        console.log("--going to update----");
        validateForm(1);
        const templateId = $("#templateId").val();
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function  /doctors/update/{id}*/
            url: `/templates/update/${templateId} `,
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'templateName':$("#templateNameEdit").val(),
                'templateType':$("#templateTypeEdit").val(),
                'templateEmailSubject':$("#templateEmailSubjectEdit").val(),
                'templateEmailBody':CKEDITOR.instances.templateEmailBodyEdit.getData(),
                'templateMessage':$("#templateMessageEdit").val()
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
            }
        });
    }

    function deleteTemplate(id) {
        bootbox.confirm("Are you sure you want to delete this template?", function (resp){
            if(resp) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/templates/destroy',
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
                        window.location.href = "/templates";
                    },
                    failure: function (data) {
                        console.log(data);
                    },
                    error:function(xhr, status, error) {
                        const resText = JSON.parse(xhr.responseText);
                        toastr.error( resText.message);
                    }
                });
            }
            else{
                return;
            }
        })
    }

</script>
@endpush