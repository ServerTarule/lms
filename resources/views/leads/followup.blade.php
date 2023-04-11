@extends('layout.app')
@section('title', 'Lead Assigning')
@section('subtitle', 'List of Leads Assigned')
@section('content')
    <div class="col-sm-12">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="LeadStatus.php">All</a></li>
                <li><a href="OperationDone.php">Operation Done</a></li>
                <li><a href="NonConnect.php">Non Connect</a></li>
                <li><a href="InProcess.php">In Process</a></li>
                <li><a href="WorkupDone.php">Workup Done</a></li>
                <li><a href="CaseClose.php">Case Close</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">

                <div class="panel panel-bd lobidrag">
                    <div class="panel-body">
                        <div class="text-right form-group">
                            <a onclick="document.getElementById('modal-18').classList.toggle('transformX-0');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Filter</a>

                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
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
                                            <a>Alternate Mobno</a>
                                        </th>
                                        <th scope="col">
                                            <a>EmailId</a>
                                        </th>
                                        <th scope="col">
                                            <a>Center Recommended</a>
                                        </th>
{{--                                        @foreach($uniqueLeadMasterNames as $leadmaster)--}}
{{--                                        <th scope="col">--}}
{{--                                            <a>{{ $leadmaster }}</a>--}}
{{--                                        </th>--}}
{{--                                        @endforeach--}}
                                        <th scope="col">
                                            <a>Latest Remark</a>
                                        </th>
                                        <th scope="col">
                                            <a>Amount</a>
                                        </th>
                                        <th scope="col">
                                            <a>File</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
{{--                                @foreach ($leads as $lead)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $loop->iteration }}</td>--}}
{{--                                        <td><a href="/leads/show/{{$lead->id}}">PID_{{ $lead->id }}</a></td>--}}
{{--                                        <td>@if( !is_null($lead->employee)) {{ $lead->employee->name }} @endif</td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td>{{ \Carbon\Carbon::parse($lead->receiveddate)->format('d/m/Y')}}</td>--}}
{{--                                        <td>{{ $lead->name }}</td>--}}
{{--                                        <td>{{ $lead->mobileno }}</td>--}}
{{--                                        <td>{{ $lead->altmobileno }}</td>--}}
{{--                                        <td>{{ $lead->email }}</td>--}}
{{--                                        <td></td>--}}
{{--                                        @foreach($lead['leadmasters'] as $lm)--}}
{{--                                            <td>@if( !is_null($lm['mastervalue'])) {{ $lm['mastervalue']->name }} @endif</td>--}}
{{--                                        @endforeach--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
