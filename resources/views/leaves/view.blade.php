@extends('layout.app')
@section('title', 'View Employee Leaves')
@section('subtitle', 'List View')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Leaves</h4>
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
                    <a class="btn btn-exp btn-sm" href="/leaves">< Back</a>
                </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead>
                                    <tr class="info">
                                       <th>S. No.</th>
                                        <th>From</th>
                                       <th>To</th>
                                       <th>Type</th>
                                       <th>Description</th>
                                       <th>No. Of Leaves</th>
                                      <th>Created Date</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                    </tr>
                                 </thead>
                            <tbody>
                                @foreach ($leaves as $leave)
                                    <tr>
                                        <td>{{ $leave->id }}</td>
                                        <td>{{ $leave->start_time }}</td>
                                        <td>{{ $leave->end_time }}</td>
                                        <td>{{ $leave->type }}</td>
                                        <td>{{ $leave->comment }}</td>
                                        <td></td>
                                        <td>{{ \Carbon\Carbon::parse($leave->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#edititem" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a>
                                        </td>
                                         <td>
                                            <a class="btn-xs btn-danger"> <i class="fa fa-trash-o"></i>  </a>
                                        </td>
                                        {{-- <td>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edititem" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                           <h3><i class="fa fa-plus m-r-5"></i> Add Leave</h3>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal" action="/addleave" method="GET" >
                                    <fieldset>
                                       <!-- Text input-->
                                       <div class="col-md-12 form-group">
                                          <label class="control-label">Employee Name</label>
                                          <input type="text" placeholder="Enter Name" name="leaveEmpyoeeName" class="form-control">
                                       </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">From Date</label>
                                          <input type="date" placeholder="From Date" name="fromDate" class="form-control">
                                       </div>
                                         <div class="col-md-6 form-group">
                                          <label class="control-label">To Date</label>
                                          <input type="date" placeholder="End Date" name="endDate" class="form-control">
                                       </div>

                                       <div class="col-md-6 form-group">
                                          <label class="control-label">From Hour</label>
                                          <input type="time" name="startTime" placeholder="To Hour" class="form-control">
                                       </div>
                                         <div class="col-md-6 form-group">
                                          <label class="control-label">To Hour</label>
                                          <input type="time" name="endTime" placeholder="To Hour" class="form-control">
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <label class="control-label">Type</label>
                                          <select class="form-control" name="leaveType">
                                             <option selected disabled> --Select Type--</option>
                                             <option>Sick Leave</option>
                                             <option>Casual Leave</option>
                                          </select>
                                       </div>
                                        <div class="col-md-12 form-group">
                                          <label class="control-label">Description</label>
                                          <textarea placeholder="Description" name="leaveDescription" class="form-control"></textarea>
                                       </div>
                                       <div class="col-md-12 form-group">
                                          <div>
                                             <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                             <button type="submit" class="btn btn-add btn-sm">Save</button>
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
         </div>
@endsection
