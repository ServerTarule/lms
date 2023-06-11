@extends('layout.app')
@section('title', 'Manage Templates')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Templates</h4>
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
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addTemplate"><i class="fa fa-plus"></i>
                            Add Template</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Type</a>
                                    </th>
                                    <th scope="col">
                                        <a>Template Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Created Date</a>
                                    </th>
                                    <th scope="col">
                                        <a>Edit</a>
                                    </th>
                                    <th scope="col">
                                        <a>Delete</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($templates as $template)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $template->type }}</td>
                                    <td>{{ $template->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($template->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <!-- <a data-toggle="modal" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a> -->
                                        <a onclick="return editTemplate({{ $template->id }})" class="btn-xs btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" id="deleteTemplate" onclick="deleteTemplate({{ $template->id }})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
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
                            <form class="form-horizontal" action="{{ route('templates.store') }}" onsubmit="return validateForm()" method="POST">
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

                                    <div class="col-md-12 form-group text-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit"  class="btn btn-add btn-sm">Save</button>
                                    </div>
                                </fieldset>
                            </form>
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
            CKEDITOR.instances.templateEmailBodyEdit.setData("");
            $("#templateEmailSubjectEdit").val("");
        }

        if($(this).val() === 'Email') {
            $("#templateMessageDivEdit").hide();
            $("#templateSubjectDivEdit").show();
            $("#templateEmailDivEdit").show();
            $("#templateMessageEdit").val("")
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
    



    function editTemplate(templateId) {
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
                    const html =  data?.template?.content;
                    CKEDITOR.instances.templateEmailBodyEdit.setData(html);
                    $("#templateMessageEdit").val(""); 
               }
               else {
                    $("#templateMessageDivEdit").show();
                    $("#templateSubjectDivEdit").hide();
                    $("#templateEmailDivEdit").hide();
                    $("#templateTypeEdit").val(templateObject?.type);
                    $("#templateNameEdit").val(templateObject?.name);
                    $("#templateMessageEdit").val(templateObject?.content);  
                    CKEDITOR.instances.templateEmailBodyEdit.setData("") 
               }
               
                $('#editTemplatePopUp').modal({
                    show: 'true'
                }); 
            },
            failure: function (data) {
                toastr.error("Error occurred while processin!!");
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