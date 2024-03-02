@extends('layout.app')
@section('title', 'First Calling')
@section('subtitle', 'Call Details')
@section('content')
    @if($lead)
    <div class="row">
        <div class="col-sm-12">                   
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <h4>Lead Information</h4>
                    </div>
                </div>
                <div class="panel-body text-right">
                    <a href="/leads" class="btn btn-warning btn-flat">
                        <i class="fa fa-arrow-left">
                            Lead Lists
                        </i>
                    </a>
                    <a href="/leads/calls/" class="btn  btn-warning btn-flat">
                        <i class="fa fa-arrow-left">
                            Lead Call
                        </i>
                    </a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        
                        <table id="dataTableExample1" class="defaultDataTable table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1" style="text-align: center;">
                                    <th>Name</th>
                                    <th>EmailId</th>
                                    <th>Mobile No</th>
                                    <th>Treatment Type</th>
                                    <th>Lead Type</th>
                                    <th>Lead Status</th>
                                    <th>Lead Stage</th>
                                    <th>Source</th>
                                    <th>Action Types</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$leadKV['name']}}</td>
                                    <td>{{$leadKV['email']}}</td>
                                    <td>{{$leadKV['mobileno']}}</td>
                                    <td>{{$leadKV['Treatment Types']}}</td>
                                    <td>{{$leadKV['Lead Types']}}</td>
                                    <td>{{$leadKV['Lead Status']}}</td>
                                    <td>{{$leadKV['Lead Stages']}}</td>
                                    <td>{{$leadKV['Lead Sources']}}</td>
                                    <td>{{$leadKV['Action Types']}}</td>
                                    <td>{{$leadKV['States']}}</td>
                                    <td>{{$leadKV['Cities']}}</td>
                                    <input type="hidden" class="ModuleName" value="FirstCallingDetails" />
                                    @php
                                        $leadKVForEditId = 0;
                                        if(isset($leadKVForEdit) &&  isset($leadKVForEdit['id'])) {
                                            $leadKVForEditId = $leadKVForEdit['id'];
                                        }
                                    @endphp
                                    <input type="hidden" id="leadId" name="leadId" value="{{$leadKVForEditId}}" />
                                    <td>
                                        @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                            <button onclick="return showMessage(1)" class="btn btn-xs btn-success btn-flat show_confirm disabled"><i class="fa fa-edit"></i></button>
                                        @else
                                            <button  id="lead-edit-button"  class="btn btn-xs btn-success btn-flat show_confirm">
                                                <i class="fa fa-edit"></i>
                                            </button> 
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if($lead) 
                    <div class="panel-body">
                        <hr>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Lead Assigned To : </label> 
                                @if($lead->employee) 
                                    {{$lead->employee->name}}   
                                    @if($lead->is_accepted) 
                                        &nbsp;(<b style="color:green">Accepted</b>)
                                    @else
                                        &nbsp;(<b style="color:red">Not Accepted</b>)
                                    @endif


                                @else
                                    Not Assigned Yet
                                @endif
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Lead Assigned At : </label> 
                                @if($lead->employee) 
                                    {{$lead->employee->lead_assigned_at}}
                                @else
                                    Not Assigned Yet
                                @endif
                               
                            </div>  
                        </div>
                        <hr>
                    </div>
                    @endif
                    
                    <div class="panel panel-bd lobidrag" id="edit-lead-div" style="display:none">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonexport">
                                <h4>Edit Lead Information</h4>
                            </div>
                        </div>
                        @if($lead)
                        <form  method="post" id="updateLeadForm" class="form-horizontal" enctype="multipart/form-data" >
                        @csrf
                            <div class="panel-body">
                                <div class="row">
                                    <fieldset>
                                        <div class="form-group col-sm-5">
                                            <label>Name <span class="text-danger required"> * </span></label>
                                            <input class="form-control Reg" id="name" name="name" placeholder="Enter Name" required="required" value="{{$lead->name}}" type="text" value="" />
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label>Email Id </label>
                                            <input class="form-control EmailId" id="email" name="email" value="{{$lead->email}}" placeholder="Enter EmailId" type="text" value="" />
                                            <span class="required" id="rqrmail" style="color: red; width: -5%; display: none;"> Please Enter Valid Email </span>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label>Mobile Number <span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                            <input class="form-control Reg MobileNo"  max-length="10"  id="mobileno" name="mobileno" value="{{$lead->mobileno}}" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter MobileNumber" required="required" type="text" value="" />
                                            <span class="required" id="rqrNumber" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number </span>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="emp_name">Alternate MobileNo.</label>
                                            <input class="form-control AlterMobile_No" id="altmobileno" name="altmobileno" value="{{$lead->altmobileno}}" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter Mobile Number" type="text" value="" />
                                            <span class="required" id="rqrAlterNumber" max-length="10" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number</span>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="emp_name">Received Date <span class="text-danger required"> * </span></label>
                                            <input
                                                autocomplete="off"
                                                class="form-control Date CurrentDate Reg hasDatepicker"
                                                data-val="true"
                                                data-val-date="The field ReceivedDate must be a date."
                                                id="receiveddate"
                                                name="receiveddate"
                                                placeholder="Enter Received Date"
                                                value="{{$lead->receiveddate ?? now()->setTimezone('T')->format('Y-m-dTh:m')}}"
                                                type="datetime-local"
                                            />
                                        </div>
                                    </fieldset>         
                                    @if($isFirstCalling)
                                    <hr>
                                    <fieldset>
                                        <div class="form-group col-sm-5">
                                            <label>Upload File(s)</label>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <input type="file" class="form-control" id="lead_file" name="lead_file[]" multiple>
                                        </div>
                                        <div class="col-md-2 form-group">
                                        <a onclick="showLeadFiles()"  class="btn btn-primary btn-sm"><i class="fa fa-eye" style="padding: 5px;" id="show-lead-files-icon">View Files List</i> </a>
                                        </div>
                                        <div class="form-group col-sm-12" id="lead-files-widget" style="display:none"> 
                                            <hr>
                                            <table id="example" class="defaultDataTable table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>File Size</th>
                                                        <th>File Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if($lead->leadFiles)
                                                    @foreach ($lead->leadFiles as $key => $leadFile)
                                                        <tr>
                                                            <td>{{$leadFile->file_name}}</td>
                                                            <td>{{$leadFile->file_size}}</td> 
                                                            <td>{{$leadFile->file_type}}</td>
                                                            <td>
                                                            <a href="/{{$leadFile->file_path}}" download><i class="fa fa-download"></i></a>
                                                            </td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>File Size</th>
                                                        <th>File Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <!-- <div class="form-group col-sm-5">
                                            <span class="divupld">
                                                <label for="myupld" class="myupldicon"><i class="fa fa-cloud-upload"></i></label>
                                                <input type="file" class="form-control" id="myupld"  name="leadFiles" />
                                            </span>
                                        </div> -->
                                    </fieldset>
                                    <hr>
                                    <fieldset>
                                        <div class="form-group col-sm-12">
                                            
                                            <h4>
                                                <strong>Center Change </strong>
                                            </h4>
                                            <i class="fa fa-info-circle" title='To Change the center, Please select State & City to get the respective center(s)' aria-hidden="true"><i> To Change the center, Please select State & City to get the respective center(s)</i></i>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label class="control-label">State</label>
                                            <select class="form-control state-dropdown" name="state" id="state-dropdown" onchange="getCityForState(this.value)" rquired >
                                                <option value="0">Select State </option>
                                                @foreach ($state as $states )
                                                    @php
                                                        $selectedStateStr = "";
                                                        if(isset($lead->state) && $lead->state == $states->id ) {
                                                            $selectedStateStr = "selected";
                                                        }
                                                    @endphp
                                                    <option value="{{$states->id}}" {{$selectedStateStr}}>{{$states->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label class="control-label">City</label>
                                            <select class="form-control city-dropdown" id="city-dropdown" name="city" onChange="getCenterForStateAndCity()" rquired >
                                                <option value="0">Select City</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label class="control-label">Center Name/Detail  <span class="required text-danger"> * </span></label>
                                            <select class="form-control center-detail" id="center-detail" name="centerId" rquired >
                                                <option value="0">Select Center</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                    <hr>
                                    @endif
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <fieldset>
                                        <div class="form-group col-sm-12">
                                            <h4>
                                            <strong>Other Information</strong>
                                            </h4>
                                        </div>
                                        @foreach($masters as $master)
                                            <div class="form-group col-sm-3">
                                                <label>
                                                    {{ $master->name }}
                                                    @if(in_array($master->id, $masterIdsToMakeDynamic))
                                                        @php
                                                            
                                                            $parentMasterName = "";
                                                            if($master->id == 4) {
                                                                $parentMasterName = "Lead Status";
                                                            }
                                                            else {
                                                                $parentMasterName = "State";
                                                            }
                                                            
                                                        @endphp
                                                        <i class="fa fa-info-circle" title='Please select "{{$parentMasterName}}" value to get value in this dropdown.' aria-hidden="true"></i>
                                                    @endif
                                                </label>
                                                <select class="form-control" name="leadMaster" onChange="getDependentData(event)" data-masterid="{{$master->id}}" id="leadMaster_{{ $master -> id }}">
                                                    <option value="0">-
                                                        - Select {{ $master->name }} -- 
                                                    </option>
                                                    @if(!in_array($master->id, $masterIdsToMakeDynamic))
                                                        @php
                                                            $values = $master->values()->get();
                                                        @endphp
                                                        @foreach($values as $value)
                                                            @php
                                                                $valueToSelect = $leadMasterKeyValueArray[$master->id];
                                                                $selectedText = '';
                                                                $selectedText = $valueToSelect == $value->id ? 'selected' :'';
                                                            @endphp
                                                            <option value="{{ $value->id }}"  {{$selectedText}}>{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                        @endforeach
                                        <div class="col-sm-12">
                                            <label>Remark</label>
                                            <div class="form-group">
                                                <textarea class="form-control Remark" cols="20" id="remark" name="remark" rows="2">{{$lead->remark}}</textarea>
                                            </div>
                                        </div>
                                        @php
                                            $leadIdForHiddenField = 0;
                                            if(isset($lead) &&  isset($lead->id)) {
                                                $leadIdForHiddenField = $lead->id;
                                            }
                                        @endphp
                                        <input class="leadId" type="hidden" id="leadId" value="{{$lead->id}}" name="leadId"  />
                                        <input type="hidden" name="leadMasters" id="leadMasters" value="{{ $masters }}">                                 
                                    </fieldset>
                                </div>        
                            </div>
                        </form>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                        <button onclick="return showMessage(1)" class="btn btn-success btn-flat show_confirm disabled">
                                            <i class="fa fa-save"> Save Lead Information</i>
                                        </button>
                                    @else
                                        <button type="button" id="leadMasterSubmitUpdate"  class="btn btn-success btn-flat show_confirm">
                                            <i class="fa fa-save "> Save Lead Information</i>
                                        </button>

                                        {{-- <button  id="lead-edit-button"  class="btn btn-xs btn-success btn-flat show_confirm">
                                            <i class="fa fa-edit"></i>
                                        </button>  --}}
                                        {{-- onclick="return editLeadCheckPermission({{ $lead->id }})" --}}
                                    {{-- <a href="#" id="lead-edit-button" class="btn btn-primary"><i class="fa fa-edit"></i></a> --}}
                                    @endif
                                    {{-- <button type="reset" id="leadMasterReset" class="btn btn-danger btn-sm">Clear</button> --}}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="panel-body">
                            <div class="row">  
                                <div class="panel panel-bd ">
                                    <div class="panel-heading">
                                        <div class="btn-group" id="buttonexport">
                                            <h4>Lead Owner Information</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group col-sm-2">
                                            <label>Owner Name  <span class="text-danger required"> * </span></label>
                                            
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <select class="form-control" name="leadEmployeeId" id="leadEmployeeId">
                                                <option value="">-- Select Owner --</option>
                                                @foreach ($employees as $employee )
                                                    @php
                                                        $selectedStateStr = "";
                                                        if(isset($lead->employee) > 0 && ($employee->id == $lead->employee->id) ) {
                                                            $selectedStateStr = "selected";
                                                        }
                                                    @endphp
                                                    <option value="{{$employee->id}}" {{$selectedStateStr}}>{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2 form-group">
                                            <label>Description</label>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                            <textarea class="form-control" id="leadCallRemark" name="leadCallRemark"></textarea>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label>Next Reminder Date <span class="text-danger required"> * </span></label>                        
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="date" class="form-control NextReminderDate reg" id="leadNextReminderDate" name="leadNextReminderDate" placeholder="dd/mm/yyyy" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <a href="/leads/calls" id="leadFollowup" class="btn btn-sm btn-primary">Follow Up</a>
                                            <a data-toggle="modal" data-target="#sendEmail" class="btn btn-sm btn-primary">Send Email</a>
                                            <a data-toggle="modal" data-target="#sendWhatsApp" class="btn btn-sm btn-primary">Send WhatsApp</a>
                                            <a class="btn btn-sm btn-success" id="submitLeadCall" type="submit">Submit</a>
                                            <a class="btn btn-sm btn-info" href="/leads/calls">< Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> 
    </div>    
    <div class="row">
        <div class="col-sm-12">                   
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <h4>Lead Owner Logs</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="defaultDataTable table table-bordered table-striped table-hover" id="table">
                        <thead>
                            <tr class="tblheadclr2" style="text-align: center;">
                                <th>S.No</th>
                                <th>Employee</th>
                                <th>Calling Date</th>
                                <th>Next Reminder Date</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leadCalls as $leadCall)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leadCall->employee?->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($leadCall->called_at)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leadCall->remind_at)->format('d/m/Y') }}</td>
                                <td>{{ $leadCall->remark }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                
    <div class="modal fade" id="sendEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:750px;width:100%">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-envelope m-r-5"></i> Send Email</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
{{--                            <form class="form-horizontal" action="{{ route('leads.email', $leadKV['id']) }}" method="POST">--}}
{{--                                @csrf--}}
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Template<span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <select name="leadEmailTemplateId" id="leadEmailTemplateId" class="form-control" >
                                            <option value="NA">-- Select Template --</option>
                                            @foreach($emailTemplates as $emailTemplate)
                                                <option value="{{ $emailTemplate->id }}">{{ $emailTemplate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">

                                        @if(isset($leadKV) && isset($leadKV['email']))
                                        <label>Email Id<span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <input type="email" placeholder="Enter Email Id" id="leadEmailId" name="leadEmailId" value="{{$leadKV['email']}}" class="form-control" />
                                        @else
                                        No Email Id Found For Sending Email
                                        @endif
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Email Subject<span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <input type="text" placeholder="Email Subject" id="leadEmailSubject" name="leadEmailSubject" class="form-control" />
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Email Body<span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <textarea placeholder="Email Body" id="leadEmailBody" name="leadEmailBody" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="submit" class="btn btn-add btn-sm" id="leadSendEmail">Send</button>
                                        </div>
                                    </div>
{{--                                    <div id="spinner-div" class="pt-5">--}}
{{--                                        <div class="spinner-border text-primary" role="status">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </fieldset>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendWhatsApp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:750px;width:100%">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-whatsapp m-r-5"></i> Send WhatsApp</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
{{--                            <form class="form-horizontal" action="{{ route('leads.whatsapp', $leadKV['id']) }}" method="POST">--}}
{{--                                @csrf--}}
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Template <span class="text-danger required"> * </span></label>
                                        <select name="leadWhatsAppTemplateId" id="leadWhatsAppTemplateId" class="form-control" >
                                            <option value="NA">-- Select Template --</option>
                                            @foreach($whatsappTemplates as $whatsappTemplate)
                                                <option value="{{ $whatsappTemplate->id }}">{{ $whatsappTemplate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        @if(isset($leadKV) && isset($leadKV['mobileno']))
                                        <label>Mobile Number <span class="text-danger required"> * </span></label>
                                        <input placeholder="Enter Mobile Number Ex: +91-0000000000" name="leadWhatsAppMobileNo" id="leadWhatsAppMobileNo" value="{{$leadKV['mobileno']}}" class="form-control" />
                                        @else
                                            No mobile no Found For Sending WhatsApp Message
                                        @endif
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Message Body <span class="text-danger required"> * </span></label>
                                        <textarea placeholder="Description" class="form-control" name="leadWhatsAppMessage" id="leadWhatsAppMessage"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="submit" class="btn btn-add btn-sm" id="leadSendWhatsApp">Send</button>
                                        </div>
                                    </div>
                                </fieldset>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else

No Information Found

@endif
@endsection
@push('custom-scripts')
<script type="text/javascript">
    const masterDependentObj = {7:8,3:4};
    const isFirstCalling = {{Js::from($isFirstCalling)}};
    @if($lead)
    const state = {{Js::from($lead->state)}};

    const city = {{Js::from($lead->city)}};
    const selectedCenterId = {{Js::from($lead->center_id)}};
    const masterDependentObjName = {7:"Cities",3:'Lead Stages'};
    const leadMasterKeyValueArray =  {{ Js::from($leadMasterKeyValueArray) }};
    @endif
</script>
<script type="text/javascript" src="/customjs/lead-edit.js"></script>
<script>
    if(state && state > 0) {
        getCityForState(state, city)
    }
    
    function validateLeadOwnerInformation (basic=1) {
        const message = '';
        isValid = true;
        //Generic Info Fields
        const validation =  {"isValid":isValid,"message":message};
        const employeeId = $("#leadEmployeeId").val();
        const reminderDate = $("#leadNextReminderDate").val();
        
        //Send WhatsApp Fields
        const templateId = $("#leadWhatsAppTemplateId").val();
        const mobileno = $("#leadWhatsAppMobileNo").val();
        const leadWhatsAppMessage = $("#leadWhatsAppMessage").val();
        // let callStatusId = $("#callStatusId").val();
        // let remark = $("#leadCallRemark").val();

        //Send Email Fields
        
        const templateIdEmail = $("#leadEmailTemplateId").val();
        const emailId = $("#leadEmailId").val();
        const leadEmailSubject = $('#leadEmailSubject').val();
        const leadEmailBody = $("#leadEmailBody").val();
        // let reminderDate = $("#leadNextReminderDate").val();

        console.log("--templateIdEmail--",templateIdEmail);
        console.log("--emailId--",emailId);
        console.log("--leadEmailSubject--",leadEmailSubject);
        console.log("--leadEmailBody--",leadEmailBody);
        if((!employeeId || employeeId === "") && basic > 0) {
            validation.message += 'Please  select owner name.';
            validation.isValid = false;
        }
        else if((!reminderDate || reminderDate === "") && (basic == 1 || basic == 3) ) {
            validation.message += 'Please  choose next reminder date.';
            validation.isValid = false;
        }
        else if((!templateId || templateId === ""  || templateId === "NA") && basic == 2) {
            validation.message += 'Please select a template.';
            validation.isValid = false;
        }
        else if((!mobileno || mobileno === "") && basic == 2) {
            validation.message += 'Please fill a mobile number to send whatsapp message.';
            validation.isValid = false;
        }
        else if((!leadWhatsAppMessage || leadWhatsAppMessage === "") && basic == 2) {
            validation.message += 'Please fill a message body to send whatsapp message.';
            validation.isValid = false;
        }
        //
        else if((!emailId || emailId === "") && basic == 3) {
            validation.message += 'Please email to send email.';
            validation.isValid = false;
        }
        else if((!templateIdEmail || templateIdEmail === "" || templateIdEmail === "NA" ) && basic == 3) {
            validation.message += 'Please select a template to send email.';
            validation.isValid = false;
        }
        else if((!leadEmailSubject || leadEmailSubject == "") && basic == 3) {
            validation.message += 'Please fill email subject.';
            validation.isValid = false;
        }
        else if((!leadEmailBody || leadEmailBody === "") && basic == 3) {
            validation.message += 'Please fill email body.';
            validation.isValid = false;
        }
        //
        // const validation =  {"isValid":isValid,"message":message};
        console.log("----validation---",validation);
        return validation;
    }
    // Lead Call Send Email
     $('#leadSendEmail').click(function() {
        let leadId = $('#leadId').val();
        let employeeId = $("#leadEmployeeId").val();
        let templateId = $("#leadEmailTemplateId").val();
        let emailId = $("#leadEmailId").val();
        let remark = $("#leadCallRemark").val();
        let reminderDate = $("#leadNextReminderDate").val();

        const validation = validateLeadOwnerInformation(3);
        console.log("--validation--".validation);
        if(!validation.isValid) {
            bootbox.alert(validation.message);
            return false;
        }
        else {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(templateId !== 'NA') {
                $.ajax({
                    url: '/leads/calls/'+leadId+'/email',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        'leadId': leadId,
                        'employeeId': employeeId,
                        'templateId': templateId,
                        'emailId': emailId,
                        'type': 'Email',
                        'remark': remark,
                        'reminderDate': reminderDate
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        // $("#spinner-div").hide();
                        window.location.href = '/leads/calls/'+leadId;
                    },
                    error:function(xhr, status, error) {
                        const resText = JSON.parse(xhr.responseText);
                        toastr.error( resText.message);
                    },
                    failure: function (data) {
                        // $("#spinner-div").hide();
                        console.log(data);
                    }
                });
            }
        }
    });
    
    // Lead Call Send WhatsApp
    $('#leadSendWhatsApp').click(function() {
        let leadId = $('#leadId').val();
        let employeeId = $("#leadEmployeeId").val();
        let templateId = $("#leadWhatsAppTemplateId").val();
        let mobileno = $("#leadWhatsAppMobileNo").val();
        let callStatusId = $("#callStatusId").val();
        let remark = $("#leadCallRemark").val();
        let reminderDate = $("#leadNextReminderDate").val();

        const validation = validateLeadOwnerInformation(2);
        console.log("--validation--".validation);
        if(!validation.isValid) {
            bootbox.alert(validation.message);
            return false;
        }
        else {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(templateId !== 'NA') {
                $.ajax({
                    url: '/leads/calls/'+leadId+'/whatsapp',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        'leadId': leadId,
                        'employeeId': employeeId,
                        'templateId': templateId,
                        'mobileno' : mobileno,
                        'type': 'WhatsApp',
                        'callStatusId': callStatusId,
                        'remark': remark,
                        'reminderDate': reminderDate
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        window.location.href = '/leads/calls/'+leadId;
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
    });

    $('#submitLeadCall').click(function() {
        let leadId = $('#leadId').val();
        let employeeId = $("#leadEmployeeId").val();
        let reminderDate = $("#leadNextReminderDate").val();
        const validation = validateLeadOwnerInformation();
        console.log("--validation--".validation);
        if(!validation.isValid) {
            bootbox.alert(validation.message);
            return false;
        }
        else {
            let remark = $("#leadCallRemark").val();
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/leads/calls/'+leadId+'/call',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'leadId': leadId,
                    'employeeId': employeeId,
                    'remark': remark,
                    'reminderDate': reminderDate
                },
                dataType: 'JSON',
                success: function (data) {
                    window.location.href = '/leads/calls/'+leadId+'';
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
        
    });
</script>
@endpush
