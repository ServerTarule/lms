@extends('layout.app')
@section('title', 'View List Of Assigned Leads')
@section('subtitle', 'List of leads')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            @if ($currentEmployeeDetails)
                            <h4>Assigned Lead Listing For {{$currentEmployeeDetails->name}}</h4>
                            @endif
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-center">

                       
                        
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
                                    <a>Accept</a>
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
                                    <td><a href="/leads/show/{{$lead->id}}?assigned=1">PID_{{$lead->id}}</a></td>
                                    <td>{{$lead->name}}</td>
                                    <td>{{$lead->email}}</td>
                                    <td>{{$lead->mobileno}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead->receiveddate)->format('d/m/Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d/m/Y')}}</td>
                                    <td>
                                        <label class="switch">
                                            <input id="action_input_{{ $lead->id }}" value="{{ $lead->is_accepted }}" type="hidden">
                                            <input id="action_toggle_{{ $lead->id }}" {{$lead->is_accepted == 1 ? 'checked':''}} type="checkbox" value="{{ $lead->is_accepted}}" onchange="toggleleadacceptancestatus(this, {{ $lead->id}}, {{$currentEmployeeDetails->id }});" @checked( $lead->is_accepted === 'true') />
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" href="/leads/calls/{{$lead->id}}" class="btn btn-xs btn-success btn-flat show_confirm">
                                            <i class="fa fa-edit"></i>
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
@endsection


@push('custom-scripts')
<script type="text/javascript">

function toggleleadacceptancestatus(cb, leadId, employeeId) {
    console.log("New Value for ser Status = " + cb.checked, "--leadId--",leadId);
    $(cb).attr('value', cb.checked);
    const status = cb.checked;
    processLeadAcceptanceStatus(status, leadId, employeeId);
    
}

function processLeadAcceptanceStatus(status, leadId, employeeId) {
    let statusTxt = ' accept ';
    let deActivateTxt = '';
    if(!status) {
        statusTxt = ' rejet ';
        deActivateTxt = " Doing so you will deny to accept the lead."
    }
    let confirmTxt = `Are you sure you want to ${statusTxt} lead?`;
    bootbox.confirm(confirmTxt, function(confirm){
        if(confirm) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            $.ajax({
                /* the route pointing to the post function */
                url: `/leads/toggleadacceptancestatus/${leadId}/${employeeId}`,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'status': status
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if(data.status) {
                        toastr.success(data.message);
                    }
                    else {
                        toastr.error(data.message);
                    }
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
        else {
            console.log("--cancelled---")
        }
    })
}
</script>
@endpush
