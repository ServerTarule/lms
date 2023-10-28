@extends('layout.app')
@section('title', 'View List Of All Leads')
@section('subtitle', 'List of leads')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                        <h4>Lead Listing</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-center">

                        @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                            <a onclick="document.getElementById('modal-18').classList.toggle('transformX-0');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Filter</a>
                            <a class="btn btn-success btn-sm" onclick="return showMessage()"><i class="fa fa-upload"></i> Bulk Upload</a>
                            <a onclick="return showMessage()" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add lead</a>
                            <div>
                                <span class="text-danger"><i class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add & upload lead(s)! Need add permission for this.  </i></span>
                            </div>

                        @else
                            <a onclick="document.getElementById('modal-18').classList.toggle('transformX-0');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Filter</a>
                            <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload"><i class="fa fa-upload"></i> Bulk Upload</a>
                            <a onclick="return addLead()" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add lead</a>
                        @endif
                        
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover defaultDataTable">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
                                <th scope="col">
                                    <a>Lead Id</a>
                                </th>
                                <th scope="col">
                                    <a>Name</a>
                                </th>
                                <th scope="col">
                                    <a>Email Id</a>
                                </th>
                                <th scope="col">
                                    <a>Mobile No</a>
                                </th>
                                <th scope="col">
                                    <a>Received Date</a>
                                </th>
                                <th scope="col">
                                    <a>Created Date</a>
                                </th>
                                <th scope="col">
                                    <a>Edit</a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($leads as $lead)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="/leads/show/{{$lead->id}}">PID_{{$lead->id}}</a></td>
                                    <td>{{$lead->name}}</td>
                                    <td>{{$lead->email}}</td>
                                    <td>{{$lead->mobileno}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead->receiveddate)->format('d/m/Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d/m/Y')}}</td>
{{--                                    <td>--}}
{{--                                        <a href="/leads/{{$lead->id}}" class="btn-xs btn-info"> <i--}}
{{--                                                class="fa fa-edit"></i> </a>--}}
{{--                                    </td>--}}
                                    <td>
                                    @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                        <button  onclick="return showMessage(1)"  class="btn btn-xs btn-success btn-flat show_confirm disabled"> 
                                            <i class="fa fa-edit" title='Edit'></i>
                                        </button>
                                    @else
                                        <a data-toggle="modal" onclick="return editLeadCheckPermission({{ $lead->id }})" class="btn btn-xs btn-success btn-flat show_confirm">
                                            <i class="fa fa-edit"></i>
                                        </a> 
                                    @endif     
                                    {{-- <a href="/leads/edit/{{$lead->id}}" id="editLead" class="btn-xs btn-info"><i class="fa fa-edit"></i></a> --}}
                                    <!-- <a href="#" id="editLead" onclick="editLead( {{ $lead->id }})" class="btn-xs btn-info">Pop<i class="fa fa-edit"></i></a> -->
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i>Upload File</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{ route('leads.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Choose Excel File</label>
                                        <input type="file" name="file" class="custom-file-input" id="customFile">
{{--                                        <input type="file" name="file"  accept=".csv, .xls, .xlsx" placeholder="Enter Source " class="form-control">--}}
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button class="btn btn-add btn-sm">Upload Excel</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="md-modal md-effect-18" id="modal-18">
        <div class="md-content">
            <div class="panel panel-bd">
                <div class="panel-heading">
                    <a onclick="document.getElementById('modal-18').classList.toggle('transformX-0');"class="btn-danger btn-sm float-end"><i class="fa fa-close"></i></a>
                    <div class="btn-group" id="buttonexport">
                        <h4>View Leads</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Treatment Type</label>
                                <select class="form-control" id="TreatmentType" name="TreatmentType">
                                    <option value="">--Select TeatmentType--</option>
                                    <option value="19">PRK or ASA</option>
                                    <option value="20">CATARACT</option>
                                    <option value="21">CONTOURA VISION</option>
                                    <option value="22">Implantable Contact Lens (ICL)</option>
                                    <option value="23">LASIK &amp; ICL</option>
                                    <option value="24">SQUINT</option>
                                    <option value="25">RELEX SMILE</option>
                                    <option value="26">LASIK &amp; SQUINT</option>
                                    <option value="27">PRESBYOPIA</option>
                                    <option value="28">LASIK</option>
                                    <option value="29">Blade-Free Lasik</option>
                                    <option value="30">SBK Lasik</option>
                                    <option value="31">Not Applicable (NA)</option>
                                    <option value="32">OTHERS</option>
                                    <option value="33">C3R Surgery</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Case Type</label>
                                <select class="form-control" id="CaseType" name="CaseType">
                                    <option value="">--Select CaseType--</option>
                                    <option value="1">Fresh Call</option>
                                    <option value="2">2nd Option</option>
                                    <option value="4">Repeated</option>
                                    <option value="8">3rd Option</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Source</label>
                                <select class="form-control" id="Source" name="Source">
                                    <option value="">--Select Source--</option>
                                    <option value="1">CALL</option>
                                    <option value="2">MAIL</option>
                                    <option value="3">Tawk-To</option>
                                    <option value="4">Whatsapp</option>
                                    <option value="5">Reference</option>
                                    <option value="6">Tawk &amp; Mail</option>
                                    <option value="7">JustDial</option>
                                    <option value="8">IVR Call</option>
                                    <option value="9">SMS Campaign</option>
                                    <option value="10">Mail Campaign</option>
                                    <option value="11">Old Case</option>
                                    <option value="12">Social Media</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Case Status</label>
                                <select class="form-control" id="ConnectStatus" name="ConnectStatus">
                                    <option value="">--Select Case Status--</option>
                                    <option value="1">Operation Done</option>
                                    <option value="2">Non connect</option>
                                    <option value="3">InProcess</option>
                                    <option value="4">Workup Done</option>
                                    <option value="8">Case Close</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>From Received Date</label>
                                <input type="text" class="form-control Date ReceivedFromDate hasDatepicker" id="ReceivedFromDate" name="ReceivedFromDate" placeholder="DD/MM/YYYY" autocomplete="off" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label>To Received Date</label>
                                <input type="text" class="form-control Date ReceivedToDate hasDatepicker" id="ReceivedToDate" name="ReceivedToDate" placeholder="DD/MM/YYYY" autocomplete="off" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Master 1 <span class="required"> * </span></label>
                                <select class="form-control" name="ConnectStatus" multiple>
                                    <option value="1">jitender</option>
                                    <option value="2">sagar</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Master 2 <span class="required"> * </span></label>
                                <select class="form-control" name="ConnectStatus" multiple>
                                    <option value="1">abc</option>
                                    <option value="2">xyz</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Master 3 <span class="required"> * </span></label>
                                <select class="form-control" name="ConnectStatus" multiple>
                                    <option value="1">xyz</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</a>
                        <a href="{{ route('leads.export') }}" class="btn btn-info btn-sm"><i class="fa fa-file"></i> Excel</a>
                        <a href="#" class="btn btn-default btn-sm"><i class="fa fa-minus"></i> Clear</a>
                    </div>
                    <div class="table-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSingleLead" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i>Edit Lead</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal"  action="{{ route('leads.updateone') }}" method="POST">
                                @csrf
                                <input class="leadId" type="hidden" id="leadId" name="leadId"  />
                                <div class="col-md-12">
                                    <h4 style="text-align: left; font-weight: bold; color: #00b0f0; text-decoration: underline;">General Information</h4>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label>Name <span class="required"> * </span></label>
                                            <input class="form-control leadName" id="leadName" name="leadName" placeholder="Enter Name" required="required" type="text"/>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Email Id</label>
                                            <input class="form-control leadEmail" id="leadEmail" name="leadEmail" placeholder="Enter EmailId" type="text"/>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Mobile Number <span style="color: red;"> * </span> </label>
                                            <input
                                                class="form-control leadMobile"
                                                id="leadMobile"
                                                maxlength="10"
                                                name="leadMobile"
                                                placeholder="Enter MobileNumber"
                                                required="required"
                                                type="text"
{{--                                                value="{{ $leadKVForEdit['mobileno'] }}"--}}
                                            />
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="emp_name">Alternate MobileNo.</label>
                                            <input
                                                class="form-control leadAlternateMobile"
                                                id="leadAlternateMobile"
                                                maxlength="10"
                                                name="leadAlternateMobile"
                                                placeholder="Enter Mobile Number"
                                                type="text"
{{--                                                value="{{$leadKVForEdit['altmobileno']}}"--}}
                                            />
                                            <span class="required" id="rqrAlterNumber" style="color: red; width: -5%; display: none;"> Please Enter Currect Number</span>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="emp_name">Received Date <span class="required"> * </span></label>
                                            <input
                                                readonly
                                                autocomplete="off"
                                                class="form-control leadReceivedDate"
                                                data-val="true"
                                                data-val-date="The field ReceivedDate must be a date."
                                                id="leadReceivedDate"
                                                name="leadReceivedDate"
                                                placeholder="Enter Received Date"
                                                type="text"
{{--                                                value="{{ \Carbon\Carbon::parse($leadKVForEdit['receiveddate'])->format('d/m/Y') }}"--}}
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4 style="text-align: left; font-weight: bold; color: #00b0f0; text-decoration: underline;">Other Information</h4>
                                    <div class="row">
                                        @foreach($masters as $master)
                                            <div class="form-group col-sm-6">
                                                <label>{{ $master->name }}<span class="required"> * </span></label>
                                                <select class="form-control leadMaster_{{ $master -> id }}" name="leadMaster_{{ $master -> id }}" id="leadMaster_{{ $master -> id }}">
                                                    <option value="0">-- Select Option --</option>
                                                    @php
                                                        $values = $master->values()->get();
                                                    @endphp
                                                    @foreach($values as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
{{--                                <div class="col-sm-12">--}}
{{--                                    <label>Remark</label>--}}
{{--                                    <div class="form-group">--}}
{{--                                        <textarea class="form-control Remark" cols="20" id="leadRemark" name="leadRemark" rows="2">{{ $leadKVForEdit['remark'] }}</textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div>
                                            <input type="submit" class="btn btn-primary" value="Update" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('custom-scripts')
<script type="text/javascript">
function editLeadCheckPermission(id) {
    const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
    if(!editPermission) {
        toastr.error("You are not allowed to edit lead!");
        return false;
    }
    else {
        window.location.href =  `/leads/calls/${id}`;
    }
}
function addLead() {
    const addPermission  = "{{$userCrudPermissions['add_permission']}}";
    if(!addPermission) {
        toastr.error("You are not allowed to add/create lead(s)!");
        return false;
    }
    else {
        window.location.href =  `/leads/create`;

    }
}
    function editLead(id) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function */
            url: '/leads/'+id,
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
                let lead = data['lead'];
                let leadmasters = data['leadmasters'];
                $('.leadId').val(lead['id']);
                $('.leadName').val(lead['name']);
                $('.leadEmail').val(lead['email']);
                $('.leadMobile').val(lead['mobileno']);
                $('.leadAlternateMobile').val(lead['altmobileno']);
                $('.leadReceivedDate').val(lead['receiveddate']);

                $.each(leadmasters, function(key, value) {
                    if(value != null) {
                        let mastervalue = value['mastervalue_id'];
                        if (mastervalue == null) {
                            mastervalue = 0;
                        }
                        $(".leadMaster_"+value['master_id']+"").val(mastervalue);
                    }
                });

                $('#editSingleLead').modal('show');
            },
            failure: function (data) {
                console.log(data);
            }
        });
    }
</script>
@endpush
