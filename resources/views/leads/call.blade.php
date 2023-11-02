@extends('layout.app')
@section('title', 'First Calling')
@section('subtitle', 'List of Calls')
@section('content')
    <div class="col-sm-12">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li @if( !$currentLeadStatus || $currentLeadStatus == 0 ) class="active"@endif><a href="?leadStatusId=0">All</a></li>
                @foreach($leadStatuses as $leadStatus)
                    <li @if( $currentLeadStatus == $leadStatus->id) class="active" @endif><a href="?leadStatusId={{ $leadStatus->id }}">{{ $leadStatus->name }}</a></li>
                @endforeach
{{--                <li class="active"><a href="LeadStatus.php">All</a></li>--}}

{{--                <li><a href="NonConnect.php">Non Connect</a></li>--}}
{{--                <li><a href="InProcess.php">In Process</a></li>--}}
{{--                <li><a href="WorkupDone.php">Workup Done</a></li>--}}
{{--                <li><a href="CaseClose.php">Case Close</a></li>--}}
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">

                <div class="panel panel-bd lobidrag">
                    <div class="panel-body">
                        <div class="text-right form-group">
                            {{-- <a onclick="document.getElementById('modal-18').classList.toggle('transformX-0');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Filter</a> --}}
                        </div>
                        <!---Grouping table Example Starts ---->
                        <table id="example-group" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">
                                        <a>S.No.</a>
                                    </th> --}}
                                    <th scope="col">
                                        <a>Details</a>
                                    </th>
                                    {{-- <th><a>Lead Id</a></th> --}}
                                    {{-- <th>Name</th> --}}
                                    {{-- <th><a>Mobileno</a></th> --}}
                                   
                                    {{-- <th><a>Rec. date</a></th> --}}
                                    {{-- <th><a>Created at</a></th> --}}
                                    {{-- <th><a>Updated at</a></th> --}}
                                    {{-- <th>master_id</th> --}}
                                    <th><a>Master Name</a></th>
                                    {{-- <th>Is master</th> --}}
                                    {{-- <th>mastervalue_id</th> --}}
                                    <th><a>Master Value</a></th>
                                    {{-- <th><a>Email</a></th> --}}
                                    {{-- <th><a>Altmobileno</a></th> --}}
                                    <th><a>View Details</a></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    {{-- <th scope="col">
                                        <a>S.No.</a>
                                    </th> --}}
                                    <th scope="col">
                                        <a>Details
                                        </a>
                                    </th>
                                    {{-- <th><a>Lead Id</a></th> --}}
                                    {{-- <th>Name</th> --}}
                                    {{-- <th><a>Mobileno</a></th> --}}
                                    
                                    {{-- <th><a>Rec. date</a></th> --}}
                                    {{-- <th><a>Created at</a></th> --}}
                                    {{-- <th><a>Updated at</a></th> --}}
                                    {{-- <th>master_id</th> --}}
                                    <th><a>Master Name</a></th>
                                    {{-- <th>Is master</th> --}}
                                    {{-- <th>mastervalue_id</th> --}}
                                    <th><a>Master Value</a></th>
                                    {{-- <th><a>Email</a></th> --}}
                                    {{-- <th><a>Altmobileno</a></th> --}}
                                    <th><a>View Details</a></th>

                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($leadsWithallNestedData as $leaddata)
                                <tr>
                                        {{-- <td>{{ $loop->iteration }}</td> --}}
                                        <td>
                                            <div>
                                                <b style="color:red">Lead Name: </b>
                                                <b style="color:rgb(3, 23, 59)">{{$leaddata->name}}</b>
                                            </div>
                                            <div>
                                                <b style="color:red">Lead ID: </b>
                                                <b style="color:rgb(3, 23, 59)"><a href="/leads/calls/{{$leaddata->leadid}}">PID_{{ $leaddata->leadid }}</a></b>
                                            </div>
                                            <div>
                                                <b style="color:red">Mobile: </b>
                                                <b style="color:rgb(3, 23, 59)"><a href="/leads/calls/{{$leaddata->leadid}}?firstcalling=1">{{ $leaddata->mobileno }}</a>
                                            </div>
                                            <div>
                                                <b style="color:red">Lead Created At: </b>
                                                <b style="color:rgb(3, 23, 59)">{{$leaddata->lead_created_at}}</b>
                                            </div>
                                            <div>
                                                <b style="color:red">Lead Update At: </b>
                                                <b style="color:rgb(3, 23, 59)">{{$leaddata->lead_last_updated_at}}</b>
                                            </div>
                                            <div>
                                                <b style="color:red">Rec. date: </b>
                                                <b style="color:rgb(3, 23, 59)">{{ \Carbon\Carbon::parse($leaddata->receiveddate)->format('d/m/Y')}}</b>
                                            </div>
                                            <div>
                                                <b style="color:red">Email: </b>
                                                <b style="color:rgb(3, 23, 59)">{{$leaddata->email}}</b>
                                            </div>
                                            <div>
                                                <b style="color:red">Alernate Mobile No.: </b>
                                                <b style="color:rgb(3, 23, 59)">{{$leaddata->altmobileno}}</b>
                                            </div>
                                            
                                        </td>
                                        {{-- <td><a href="/leads/calls/{{$leaddata->leadid}}">PID_{{ $leaddata->leadid }}</a></td> --}}
                                        {{-- <td>{{$leaddata->name}}</td> --}}
                                        {{-- <td><a href="/leads/calls/{{$leaddata->leadid}}?firstcalling=1">{{ $leaddata->mobileno }}</a></td> --}}
                                        {{-- <td>{{ \Carbon\Carbon::parse($leaddata->receiveddate)->format('d/m/Y')}}</td> --}}
                                        {{-- <td>{{$leaddata->lead_created_at}}</td> --}}
                                        {{-- <td>{{$leaddata->lead_last_updated_at}}</td> --}}
                                        {{-- <td>{{$leaddata->master_id}}</td> --}}
                                        {{-- <td><b style="color:{{$colourCode[$leaddata->master_id]}}">{{$leaddata->master_name}}</b></td>--}}
                                        <td><b >{{$leaddata->master_name}}</b></td>
                                        {{-- <td>{{$leaddata->mastervalue_id}}</td> --}}
                                        {{-- <td>{{$leaddata->master}}</td> --}}
                                        <td>{{$leaddata->master_value_name}}</td>
                                       
                                        {{-- <td>{{$leaddata->email}}</td> --}}
                                        {{-- <td>{{$leaddata->altmobileno}}</td> --}}
                                        <td >
                                            <a class="btn btn-xs btn-warning btn-flat" href="/leads/show/{{$leaddata->leadid}}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    
                                </tr>
                                @endforeach
                            <tbody>
                          
                        </table>
                        <!---Grouping table Example Ends ---->

                        @if($showold == 1) 
                        <div class="table-responsive">
                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover     ">
                                <thead>
                                    <tr class="tblheadclr1">
                                        <th scope="col">
                                            <a>S.No.</a>
                                        </th>
                                        <th scope="col">
                                            <a>LeadId</a>
                                        </th>
                                        <th scope="col">
                                            <a>OwnerName</a>
                                        </th>
                                        <th scope="col">
                                            <a>Next ReminderDate</a>
                                        </th>
                                        <th scope="col">
                                            <a>Left Days</a>
                                        </th>
                                        <th scope="col">
                                            <a>Received Date</a>
                                        </th>
                                        <th scope="col">
                                            <a>Name</a>
                                        </th>
                                        <th scope="col">
                                            <a>MobileNo</a>
                                        </th>
                                        <th scope="col">
                                            <a>Alternate Mob. No.</a>
                                        </th>
                                        <th scope="col">
                                            <a>EmailId</a>
                                        </th>
                                        <th scope="col">
                                            <a>Center Recommended</a>
                                        </th>
                                        @foreach($uniqueLeadMasterNames as $leadmaster)
                                        <th scope="col">
                                            <a>{{ $leadmaster }}</a>
                                        </th>
                                        @endforeach
                                        <th scope="col">
                                            <a>Latest Remark</a>
                                        </th>
                                        <th scope="col">
                                            <a>Amount</a>
                                        </th>
                                        <th scope="col">
                                            <a>File</a>
                                        </th>
                                        <th scope="col">
                                            <a>Lead Details</a>
                                        </th>
                                        {{-- href="/leads/show/{{$lead->id}}" --}}
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($leads as $lead)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="/leads/calls/{{$lead->id}}">PID_{{ $lead->id }}</a></td>
                                        <td>@if( !is_null($lead->employee)) {{ $lead->employee->name }} @endif</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ \Carbon\Carbon::parse($lead->receiveddate)->format('d/m/Y')}}</td>
                                        <td>{{ $lead->name }}</td>
                                        <td><a href="/leads/calls/{{$lead->id}}">{{ $lead->mobileno }}</a></td>
                                        <td>{{ $lead->altmobileno }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td></td>
                                        @foreach($lead['leadmasters'] as $lm)
                                            <td>@if( !is_null($lm['mastervalue'])) {{ $lm['mastervalue']->name }} @endif</td>
                                        @endforeach
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th >
                                            <a class="btn btn-xs btn-warning btn-flat" href="/leads/show/{{$lead->id}}"><i class="fa fa-eye"></i></a>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
