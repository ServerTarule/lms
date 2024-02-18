@extends('layout.app')
@section('title', 'Email/WhatsApp Schedules')
@section('subtitle', 'List of Schedules')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Schedules</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                            <span class="text-danger"><i class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add employee(s).  </i></span>
                            <button class="btn btn-exp btn-sm disabled" onclick="return showMessage()">
                                <i class="fa fa-plus"></i> Schedule Action
                            </button>
                        @else
                            {{-- <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addSchedule"><i
                            class="fa fa-plus"></i> Schedule Action</a> --}}
                            <button class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addSchedule">
                                <i class="fa fa-plus"></i> Schedule Action
                            </button>
                        @endif
                        
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="defaultDataTable table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    <a>S.No.(ID)</a>
                                </th>
                                <th scope="col">
                                    <a>Rule</a>
                                </th>
                                <th scope="col">
                                    <a>Type</a>
                                </th>
                                <th scope="col">
                                    <a>Template Name</a>
                                </th>
                                <th scope="col">
                                    <a>Scheduled/Send Now</a>
                                </th>
                                <th scope="col text-center">
                                    <a>Count (View Related Leads) </a>
                                </th>
{{--                                <th scope="col">--}}
{{--                                    <a>Date</a>--}}
{{--                                </th>--}}
{{--                                <th scope="col">--}}
{{--                                    <a>Time</a>--}}
{{--                                </th>--}}
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
                            @foreach ($communications as $communication)
                                <tr>
                                    <td>{{ $loop->iteration }} &nbsp; ({{ $communication->id }})</td>
                                    <td>{{ $communication->rule?->name }}</td>
                                    <td>{{ $communication->type }}</td>
                                    <td>{{ $communication->template?->name }}</td>
                                    <td>{{ $communication->words }}</td>
                                    <td>
                                        @if ((isset($userCrudPermissions['view_permission'] ) &&  $userCrudPermissions['view_permission'] != 1))
                                            <button  onclick="return showMessage(3)"  class="btn btn-xs btn-warning btn-flat show_confirm disabled"> 
                                                <i class="fa fa-eye" title='Edit'></i>
                                            </button>
                                        @else
                                        <a  class="btn btn-xs btn-warning btn-flat show_confirm" href="/communications/{{$communication->id}}/leads">
                                            <i class="fa fa-eye"></i> {{ $communication->leads()->count() }}
                                        </a>
                                        @endif
                                    </td> 
{{--                                    <td></td>--}}
{{--                                    <td>{{ \Carbon\Carbon::parse($holiday->day)->format('d/m/Y') }}</td>--}}
                                    <td>{{ \Carbon\Carbon::parse($communication->created_at)->format('d/m/Y') }}</td>
{{--                                    <td>--}}
{{--                                        <a href="#" data-toggle="modal" data-target="#editSchedule" id="editCommunicationSchedule" class="btn-xs btn-info"><i class="fa fa-edit"></i></a>--}}
{{--                                    </td>--}}
                                    <td>
                                        {{-- <a href="#" id="editCommunicationSchedule" onclick="editCommunication( {{ $communication->id }})" class="btn-xs btn-info"><i class="fa fa-edit"></i></a> --}}
                                        @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                            <button  onclick="return showMessage(1)"  class="btn btn-xs btn-success btn-flat show_confirm disabled"> 
                                                <i class="fa fa-edit" title='Edit'></i>
                                            </button>
                                        @else
                                            <button href="#" id="editCommunicationSchedule" onclick="editCommunication( {{ $communication->id }})" class="btn btn-xs btn-success btn-flat show_confirm">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            
                                        @endif  
                                    </td>
                                    <td>
                                        @if ((isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1))
                                            <button  onclick="return showMessage(2)"  class="btn btn-xs btn-danger btn-flat show_confirm disabled"> 
                                                <i class="fa fa-trash-o" title='Delete'></i>
                                            </button>
                                        @else
                                            <button href="#" id="deleteCommunication" onclick="deleteCommunication( {{ $communication->id }})" class="btn btn-xs btn-flat show_confirm btn-xs btn-danger">
                                                <i class="fa fa-trash-o"  title='Delete'></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSchedule" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Email/WhatsApp Scheduler</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning" style="padding:5px!important; display:none">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true">
                                    <span id="showMessage" class="font-italic">
                                        
                                    </span>
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <form  method="post" id="addScheduleForm" class="form-horizontal" enctype="multipart/form-data" >
                                @csrf
                                <fieldset>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Rule</label>
                                        <select data="Add" name="ruleId" id="ruleId" class="form-control" onChange="return getDateCountForRule(0)">
                                            <option value="">--Select Rule--</option>
                                            @foreach($rules as $rule)
                                                <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Type</label>
                                        <select data="Add" id="communicationTemplateType" name="communicationTemplateType" class="form-control">
                                            <option value="NA">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Template</label>
                                        <select data="Add" name="communicationTemplateId" id="communicationTemplateId" class="form-control">
                                            <option value="NA">--Select Template--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group" id="communicationTemplateSubjectDiv" style="display:none">
                                        <label class="control-label">Email Subject</label>
                                        <input data="Add" class="form-control" type="text" name="communicationTemplateSubject" id="communicationTemplateSubject" placeholder="Please type here..">
                                    </div>
                                    <div class="col-md-12 form-group" id="communicationTemplateMessageDiv" style="display:none">
                                        <label class="control-label" id="control-label">WhatsApp Message</label>
                                        <textarea data="Add" class="form-control" id="communicationTemplateMessage" name="communicationTemplateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-12 form-group" id="communicationTemplateBodyDiv" style="display:none">
                                        <label class="control-label">Email Body</label>
                                        <textarea data="Add" class="form-control" id="communicationTemplateBody" name="communicationTemplateBody" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label"><input data="Add" type="radio" value="scheduled" id="communicationSchedule" name="schedule" checked/> &nbsp;&nbsp;&nbsp;&nbsp;Scheduled</label>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label"><input data="Add" type="radio" value="now" id="communicationNow" name="schedule"/>&nbsp;&nbsp;&nbsp;&nbsp; Send Now</label>
                                    </div>
                                    <div id="communicationScheduleDiv">
                                        <div class="col-md-3 form-group">
                                            <select data="Add" name="scheduleUnit" id="scheduleUnit" class="form-control">
                                                <option value="0">Select Schedule Unit</option>
                                                @foreach($scheduleUnitArray as $scheduleUnitKey=>$scheduleUnitLabel)
                                                    <option value="{{$scheduleUnitKey}}">{{$scheduleUnitLabel}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group" id="dayOfWeekDiv">
                                            <select data="Add" id="dayOfWeek" name="dayOfWeek" class="form-control">
                                                <option value="NA">--Select Day--</option>
                                                @foreach($daysArray as $dayKey=>$dayLabel)
                                                    <option value="{{$dayKey}}">{{$dayLabel}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="communicationNowDiv">
                                        <div class="col-md-3 form-group" id="dayOfMonthDiv">
                                            <select data="Add" id="dayOfMonth" name="dayOfMonth" class="form-control">
                                                <option value="NA">--Select  Date--</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input data="Add" type="time" id="minuteHour" name="minuteHour" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 form-group text-right">
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="addScheduleButton" class="btn btn-add btn-sm">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSchedule" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-pencil m-r-5"></i> Email/WhatsApp Scheduler</h3>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning" style="padding:5px!important;  display:none">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true">
                                    <span id="showMessageEdit" class="font-italic">
                                        
                                    </span>
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form  method="post" id="updateScheduleForm" class="form-horizontal" enctype="multipart/form-data" >
                            <!-- <form class="form-horizontal" id="updateScheduleForm" action="{{ route('communications.update') }}" method="POST"> -->
                                @csrf
                                <fieldset>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Rule</label>
                                        <select data="Edit" name="ruleId" id="ruleIdEdit" class="form-control ruleId" onChange="getDateCountForRule(1)">
                                            <option value="">--Select Rule--</option>
                                            @foreach($rules as $rule)
                                                <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Type</label>
                                        <select data="Edit" id="communicationTemplateTypeEdit" name="communicationTemplateType" class="form-control communicationTemplateType">
                                            <option value="NA">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Template</label>
                                        <select data="Edit" name="communicationTemplateId" id="communicationTemplateIdEdit" class="form-control communicationTemplateId">
                                            <option value="NA">--Select Template--</option>
                                            <!-- @foreach($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                                            @endforeach -->
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group communicationTemplateSubjectDivEdit" id="communicationTemplateSubjectDivEdit">
                                        <label class="control-label">Email Subject</label>
                                        <input data="Edit" class="form-control communicationTemplateSubject" type="text" name="communicationTemplateSubject" id="communicationTemplateSubjectEdit" placeholder="Please type here..">
                                    </div>
                                    <div class="col-md-12 form-group communicationTemplateMessageDivEdit" id="communicationTemplateMessageDivEdit">
                                        <label class="control-label" id="control-label">WhatsApp Message</label>
                                        <textarea data="Edit" class="form-control communicationTemplateMessage" id="communicationTemplateMessageEdit" name="communicationTemplateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-12 form-group communicationTemplateBodyDivEdit" id="communicationTemplateBodyDivEdit">
                                        <label class="control-label">Email Body</label>
                                        <textarea data="Edit" class="form-control communicationTemplateBody" id="communicationTemplateBodyEdit" name="communicationTemplateBody" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div class="col-md-4 form-group col-md-6 text-left">
                                            <label class="control-label">Current Schedule (In Words) </label>
                                        </div>
                                        <div class="col-md-8">
                                            <span  id="scheduleWords"></span> 
                                            &nbsp;&nbsp;&nbsp;
                                            <i title="Click here to update the schedule" class="fa fa-pencil m-r-5" style="cursor: pointer; display:none" id="editScheduleUnit"></i>
                                            <i title="Click here to close updating the schedule" class="fa fa-close m-r-5" style="cursor: pointer; display:none" id="editScheduleUnitClose"></i>
                                        </div>
                                    </div>
                                    <div class="row" id="scheduleUnitFieldSet" style="display:block">
                                        <input type="hidden" id="allowEditing" value="0">
                                        <div class="col-md-12 form-group text-center">
                                            <label class="control-label">
                                                -----Edit Below Details For Changing Current Schedule-----
                                            </label>
                                        </div>
                                    
                                        <div class="col-md-6 form-group">
                                            <label class="control-label communicationSchedule"><input  data="Edit" type="radio" value="scheduled" id="communicationScheduleEdit" name="schedule" checked/>Scheduled</label>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label communicationNow"><input data="Edit"  type="radio" value="now" id="communicationNowEdit" name="schedule"/>Send Now</label>
                                        </div>
                                   

                                        <div id="editCommunicationScheduleDiv">
                                            <div class="col-md-3 form-group">
                                                <select  data="Edit" name="scheduleUnit" id="scheduleUnitEdit" class="form-control scheduleUnit">
                                                    <option value="0">Select Schedule Unit</option>
                                                    @foreach($scheduleUnitArray as $scheduleUnitKey=>$scheduleUnitLabel)
                                                        <option value="{{$scheduleUnitKey}}">{{$scheduleUnitLabel}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 form-group" id="dayOfWeekDivEdit">
                                                <select  data="Edit" id="dayOfWeekEdit" name="dayOfWeek" class="form-control dayOfWeek">
                                                    <option value="NA">--Select Day--</option>
                                                    @foreach($daysArray as $dayKey=>$dayLabel)
                                                        <option value="{{$dayKey}}">{{$dayLabel}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="editCommunicationNowDiv">
                                            <div class="col-md-3 form-group" id="dayOfMonthDivEdit">
                                                <select  data="Edit" id="dayOfMonthEdit" name="dayOfMonth" class="form-control dayOfMonth">
                                                    <option value="NA">--Select Date--</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor 
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input  data="Edit" type="time" id="minuteHourEdit" name="minuteHour" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <input type ="hidden" name="communicationId" id="communicationId" >

                            </form>
                            <div class="col-md-12 form-group text-right">
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-add btn-sm" id="updateScheduleButton">Save</button>
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
<script type="text/javascript">
// alert("heeheheheh");
// CKEDITOR.replace("communicationTemplateBody", {
//     height: 100
// });


$('select[name="templateType"]').change(function() {
    if($(this).val() === 'WhatsApp') {
        $("#templateMessageDiv").show();
        $("#templateSubjectDiv").hide();
        $("#templateEmailDiv").hide();
    }

    if($(this).val() === 'Email') {
        $("#templateMessageDiv").hide();
        $("#templateSubjectDiv").show();
        $("#templateEmailDiv").show();
    }
});

function validateForm(isEdit=false) {
    let isValid = true;
    let validationMessage = "<b>Please follow below instruction before submitting form.</b><ul>";
    const rule = (isEdit)?$("#ruleIdEdit").val():$("#ruleId").val();
    const communicationTemplateType = (isEdit)?$("#communicationTemplateTypeEdit").val():$("#communicationTemplateType").val();
    const communicationTemplateId = (isEdit)?$("#communicationTemplateIdEdit").val():$("#communicationTemplateId").val();
    const communicationTemplateMessage = (isEdit)?$("#communicationTemplateMessageEdit").val():$("#communicationTemplateMessage").val();
    let communicationTemplateBody ='';
    if(isEdit && CKEDITOR.instances.communicationTemplateBodyEdit) {
        communicationTemplateBody = CKEDITOR.instances.communicationTemplateBodyEdit.getData();

    }
    else if(!isEdit && CKEDITOR.instances.communicationTemplateBody) {
        // alert("not edit===="+CKEDITOR.instances.communicationTemplateBody.getData());
        communicationTemplateBody = CKEDITOR.instances.communicationTemplateBody.getData()
    }
    const communicationTemplateSubject = (isEdit)?$("#communicationTemplateSubjectEdit").val():$("#communicationTemplateSubject").val();
    const communicationSchedule = (isEdit)?$("#communicationScheduleEdit").val():$("#communicationSchedule").val();
    const communicationNow = (isEdit)?$("#communicationNowEdit").val():$("#communicationNow").val();
    const scheduleUnit = (isEdit)?$("#scheduleUnitEdit").val():$("#scheduleUnit").val();
    const dayOfWeek = (isEdit)?$("#dayOfWeekEdit").val():$("#dayOfWeek").val();
    const dayOfMonth = (isEdit)?$("#dayOfMonthEdit").val():$("#dayOfMonth").val();
    const minuteHour = (isEdit)?$("#minuteHourEdit").val():$("#minuteHour").val();
    if(!rule || rule == null || rule == "") {
        validationMessage += `<li>Please select a rule. </li>`; 
        isValid=false;
    }
    if(communicationTemplateType == null || communicationTemplateType =="NA") {
        isValid=false;
        validationMessage += `<li>Please select a type.</li>`; 
    }
    if(communicationTemplateId == null || communicationTemplateId =="NA") {
        validationMessage += `<li>Please select a template. </li>`; 
        isValid=false;
    }
    if(communicationTemplateType ==="WhatsApp" && (communicationTemplateMessage == null || communicationTemplateMessage =="")) {
        validationMessage += `<li>Please fill whatsapp message. </li>`; 
        isValid=false;
    }
    if(communicationTemplateType ==="Email" && (communicationTemplateSubject == null || communicationTemplateSubject =="")) {
        validationMessage += `<li>Please fill email Subject. </li>`; 
        isValid=false;
    }
    if(communicationTemplateType ==="Email" && (communicationTemplateBody == null || communicationTemplateBody =="")) {
        validationMessage += `<li>Please fill email body. </li>`; 
        isValid=false;
    }

    const isNow = (isEdit)?$('#communicationNowEdit').is(':checked'):$('#communicationNow').is(':checked');
    if(!isNow) {
        if(scheduleUnit ==0 || scheduleUnit == null) {
            validationMessage += `<li>Please select schedule unit. </li>`; 
            isValid=false;
        }
        if(scheduleUnit=='WEEKLY' && dayOfWeek == 'NA') {
            validationMessage += `<li>Please select a day. </li>`; 
            isValid=false;
        }
        if(scheduleUnit=='MONTHLY' && dayOfMonth == 'NA') {
            validationMessage += `<li>Please select a date. </li>`; 
            isValid=false;
        }
    }
    
    if(!isValid) {
        toastr.error(validationMessage);
        bootbox.alert(validationMessage);
        // bootbox.alert(validationMessage, function(){
        //     return true;
        // });
    }
    return isValid;

    }
$("#addScheduleButton").click(function(){
    const isValid = validateForm(false);
    // alert("==isValid=="+isValid);
    if(isValid) {
        processAdd();
    }
});

$("#updateScheduleButton").click(function(){
    const isValid = validateForm(true);
    // alert("==isValid=="+isValid);
    if(isValid) {
        processUpdate();
    }
});

function processUpdate () {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // const data = $("#addScheduleButton").formData()
    var form_data = new FormData($('#updateScheduleForm')[0]);    

    console.log("--form_data--",form_data);
    $.ajax({
        /* the route pointing to the post function */
        url: '/communications/update',
        /* send the csrf-token and the input to the controller */
        data: form_data,
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            if(data.error) {
                toastr.error(data.message);
            }
            else {
                toastr.success(data.message);
                // $("#addScheduleForm")[0].reset()
        $('#editSchedule').modal('toggle');
                setTimeout(function(){ 
                    // location.reload();
                }, 3000);
            }
            
        },
        error:function(xhr, status, error) {
            const resText = JSON.parse(xhr.responseText);
            toastr.error( resText.message);
        },
        failure: function (data) {
            toastr.error("Error occurred while processing!!");
        }
    });
}

function processAdd () {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var form_data = new FormData($('#addScheduleForm')[0]);    
    console.log("--form_data--",form_data);
    // form_data.append(`isFirstCalling`,isFirstCalling);
    let communicationTemplateBody = "";
    if(CKEDITOR.instances.communicationTemplateBody) {
        communicationTemplateBody = CKEDITOR.instances.communicationTemplateBody.getData()
    }
    form_data.append(`communicationTemplateBody`, communicationTemplateBody)
    $.ajax({
        /* the route pointing to the post function */
        url: '/communications/store',
        /* send the csrf-token and the input to the controller */
        data: form_data,
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            if(data.error) {
                toastr.error(data.message);
            }
            else {
                toastr.success(data.message);
                $("#addScheduleForm")[0].reset()
                $('#addSchedule').modal('toggle');
                setTimeout(function(){ 
                    location.reload();
                }, 3000);
            }
            
        },
        error:function(xhr, status, error) {
            const resText = JSON.parse(xhr.responseText);
            toastr.error( resText.message);
        },
        failure: function (data) {
            toastr.error("Error occurred while processing!!");
        }
    });
}

function changeValuesWrtScheduleUnit(self) {
    console.log("Self Value ==",$(self).val());
    const typeData = $(self).attr('data');
    console.log("==typeData=="+typeData);
    let editText='';
    if(typeData === 'Edit') {
        editText = typeData;
    }
    console.log("--editText---",editText);
    //MONTHLY
    console.log("==dayOfWeek${editText}==",`dayOfWeek${editText}`);
    console.log("==dayOfMonth${editText}==",`dayOfMonth${editText}`);
    if($(self).val() === 'DAILY') {
        
        console.log("--daily condition---",editText);
        // $("#dayOfWeekDiv *, #dayOfMonthDiv *").prop('disabled',false);
        // $("#dayOfWeekDiv").val('NA').change();
        // $("#dayOfMonthDiv").val('NA').change();
        $(`#dayOfWeek${editText}`).prop('disabled',true);
        $(`#dayOfMonth${editText}`).prop('disabled',true);
        // #dayOfMonthDiv${editText}
        $("#minuteHour").val("00:00");
    } else if ($(self).val() === 'WEEKLY') {
        console.log("--WEEKLY condition---",editText);
        // $(`#dayOfWeekDiv${editText} *`).prop('disabled',false);
        // $(`#dayOfMonthDiv${editText} *`).prop('disabled',true);

        $(`#dayOfWeek${editText}`).prop('disabled',false);
        $(`#dayOfMonth${editText}`).prop('disabled',true);
        $(`#minuteHour${editText}`).val("00:00");
    } 
    else if ( $(self).val() === 'MONTHLY' || $(self).val() === 'MONTHLY') { //$(this).val() === 'FORTNIGHTLY' ||
        console.log("Inside other Condition");
        // $(`#dayOfWeekDiv${editText} *, #dayOfMonthDiv *`).prop('disabled',false);
        // $(`#dayOfWeekDiv${editText} *`).prop('disabled',true);

        $(`#dayOfWeek${editText}`).prop('disabled',false);
        $(`#dayOfMonth${editText}`).prop('disabled',false);
        $(`#dayOfWeek${editText}`).prop('disabled',true);
    } 
    else {
        // $(`#dayOfWeekDiv${editText} *, #dayOfMonthDiv${editText} *`).prop('disabled',true);
        $(`#dayOfWeek${editText}`).prop('disabled',true);
        $(`#dayOfMonth${editText}`).prop('disabled',true);
    }
}

$('select[name="scheduleUnit"]').change(function() {
    changeValuesWrtScheduleUnit(this);
});

function editCommunication(id) {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // CKEDITOR.replace("communicationTemplateBodyEdit", {
    //     height: 100
    // });
    $.ajax({
        /* the route pointing to the post function */
        url: '/communications/'+id,
        type: 'GET',
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
            let communicationSchedule = data['schedule'];
            console.log("----Data found----", data, communicationSchedule);
            let templateTypeData = communicationSchedule['type'];
            console.log("--communicationSchedule---",communicationSchedule,'---templateTypeData---',templateTypeData);
            let template_id = communicationSchedule['template_id'];
            $('#communicationId').val(communicationSchedule['id']);
            $('.ruleId').val(communicationSchedule['rule_id']);
           
            
            // const that = $("#scheduleUnitEdit");
            // changeValuesWrtScheduleUnit(that)
            $('#communicationTemplateTypeEdit').val(templateTypeData);//.change();
            const subject = communicationSchedule['subject'];
            const message = communicationSchedule['message'];
            const content= communicationSchedule['content'];
            // alert("--templateTypeData---"+templateTypeData)
            setTemplateNames(templateTypeData, true, template_id, subject, message);
            // const that = $("#communicationTemplateId");
            // fetchRelatedTemplatesData();
            if(templateTypeData === 'WhatsApp') {
                $(".communicationTemplateMessageDivEdit").show();
                $(".communicationTemplateSubjectDivEdit").hide();
                $(".communicationTemplateBodyDivEdit").hide();
            }
            if(templateTypeData === 'Email') {
                $(".communicationTemplateMessageDivEdit").hide();
                $(".communicationTemplateSubjectDivEdit").show();
                $(".communicationTemplateBodyDivEdit").show();
                // CKEDITOR.instances.templateEmailBodyEdit.setData(html);
            }
            $('.communicationTemplateId').val(communicationSchedule['template_id']);
            $('.communicationTemplateSubject').val(subject);
            $('.communicationTemplateMessage').val(message);
            $('.communicationTemplateBody').val(content);
            $('#scheduleUnitEdit').trigger("change")
            const savedSchedule = communicationSchedule['schedule'];
            if(savedSchedule){
                const savedScheduleArr  = savedSchedule.split(' ');
                console.log("===savedScheduleArr==",savedScheduleArr);
                const dayOfWeek = savedScheduleArr[4]=='*'?'NA':savedScheduleArr[4];
                const dateOfMonth = savedScheduleArr[2]=='*'?'NA':savedScheduleArr[2];
                $(`#dayOfWeekEdit`).val(dayOfWeek);
                $(`#dayOfMonthEdit`).val(dateOfMonth);
                const minute =  savedScheduleArr[0]?savedScheduleArr[0]:'00';
                const hour =  savedScheduleArr[1]?savedScheduleArr[1]:'00';
                $("#minuteHourEdit").val(`${hour}:${minute}`);
            }
            console.log(communicationSchedule['words']+"---"+communicationSchedule['schedule'])
            $('#scheduleWords').html(communicationSchedule['words']);
            let schedule = communicationSchedule['schedule'];

            if (schedule === 'now') {
                $('input:radio[name="schedule"]').filter('[value="'+schedule+'"]').attr('checked', true);
                $("#editCommunicationNowDiv *").prop('disabled',true);
                $("#editCommunicationScheduleDiv *").prop('disabled',true);
            } else {
                $("#editCommunicationScheduleDiv *").prop('disabled',false);
                $("#editCommunicationNowDiv *").prop('disabled',false);


            }

            const schedule_unit = communicationSchedule['schedule_unit'];
            if(schedule_unit) {
                $("#scheduleUnitEdit").val(schedule_unit);
                if(schedule_unit === 'DAILY') {
                    $(`#dayOfWeekEdit`).prop('disabled',true);
                    $(`#dayOfMonthEdit`).prop('disabled',true);
                    // $("#minuteHourEdit").val("00:00");
                } else if (schedule_unit === 'WEEKLY') {
                    $(`#dayOfWeekEdit`).prop('disabled',false);
                    $(`#dayOfMonthEdit`).prop('disabled',true);
                    $(`#minuteHourEdit`).val("00:00");
                } 
                else if ( schedule_unit === 'MONTHLY' || schedule_unit === 'MONTHLY') {
                    console.log("Inside other Condition");
                    $(`#dayOfWeekEdit`).prop('disabled',false);
                    $(`#dayOfMonthEdit`).prop('disabled',false);
                    $(`#dayOfWeekEdit`).prop('disabled',true);
                } 
                else {
                    $(`#dayOfWeekEdit`).prop('disabled',true);
                    $(`#dayOfMonthEdit`).prop('disabled',true);
                }
            }
            

            $('#editSchedule').modal('show');
        },
        error:function(xhr, status, error) {
            const resText = JSON.parse(xhr.responseText);
            toastr.error( resText.message);
        },
        failure: function (data) {
            console.log(data);
        }
    });

    // $("#editScheduleUnit").click(function(){
    //     $("#allowEditing").val(1);
    //     $("#scheduleUnitFieldSet").show();
    //     $("#editScheduleUnitClose").show();
    //     $(this).hide()
    //     //scheduleUnitFieldSet/allowEditing
    // });
    // $("#editScheduleUnit").click(function(){
    //     $("#allowEditing").val(0);
    //     $("#scheduleUnitFieldSet").show();
    //     $("#editScheduleUnitClose").show();
    //     $(this).hide()
    //     //scheduleUnitFieldSet/allowEditing
    // })
}


function getDateCountForRule(isEdit) {
    let ruleId = $("#ruleId").val();
    if(isEdit == 1) {
        ruleId = $("#ruleIdEdit").val();
    }
    const apiUrl = `/communications/getDayCount/${ruleId}`;
    if(ruleId) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function */
            url: apiUrl,
            type: 'GET',
            /* send the csrf-token and the input to the controller */
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                console.log(data);
                //i.e. on ${data.date}
                const message = `On selecting this rule system will consider leads which has been updated before ${data.count} days i.e. on ${data.date} for sending message.`;
                // $("#showMessage").html(`On selecting this rule you will `);
                toastr.warning(message);
                // toastr.error(validationMessage);
            },
            error:function(xhr, status, error) {
                const resText = JSON.parse(xhr.responseText);
                toastr.error( resText.message);
            },
            failure: function (data) {
                console.log(data);
            }
        });
    
    }
}

function deleteCommunication(id) {

    bootbox.confirm("Are you sure you want to delete this schedule?", confirm =>{
        if(confirm) {
            processDeleteCommunication(id);
        }
        else {
            return;
        }
    });
}

function processDeleteCommunication(id) {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        /* the route pointing to the post function */
        url: '/communications/destroy',
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
            window.location.href = "/communications";
        },
        error:function(xhr, status, error) {
            const resText = JSON.parse(xhr.responseText);
            toastr.error( resText.message);
        },
        failure: function (data) {
            console.log(data);
        }
    });
}

</script>
@endpush