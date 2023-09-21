@extends('layout.app')
@section('title', 'Lead Assigning')
@section('subtitle', 'List of Leads Assigned')
@section('content')
    <div class="col-sm-12">
         {{-- <div class="panel-body">
                <nav>
                    <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                        <li class="active">
                            <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                Home
                            </a>
                        </li>
                        <li>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                                Contact
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <p>Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat cupidatat. Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip ipsum aute laboris nisi. Labore labore veniam irure irure ipsum pariatur mollit magna in cupidatat dolore magna irure esse tempor ad mollit. Dolore commodo nulla minim amet ipsum officia consectetur amet ullamco voluptate nisi commodo ea sit eu.</p>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <p>Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor esse fugiat sunt do. Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim cupidatat. Deserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod qui reprehenderit nostrud tempor. Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit enim. Consequat aliquip incididunt ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id nulla minim nostrud labore eiusmod et amet. Laboris consequat consequat commodo non ut non aliquip reprehenderit nulla anim occaecat. Sunt sit ullamco reprehenderit irure ea ullamco Lorem aute nostrud magna.</p>
                    </div>
                </div>
        </div> --}}
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
