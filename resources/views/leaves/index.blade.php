@extends('layout.app')
@section('title', 'Employee Leaves')
@section('subtitle', 'List of Leaves')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Employee Leaves</h4>
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
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i class="fa fa-plus"></i>
                            Add Leave</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Employee Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Upcoming Leaves</a>
                                    </th>

                                    <th scope="col">
                                        <a>List View</a>
                                    </th>
                                    <th scope="col">
                                        <a>Calender View</a>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaves as $leave)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $leave->employee->name  }}</td>
                                        <td></td>
                                        <td>
                                            <a href="/leaves/{{ $leave->id }}" class="btn-xs btn-success"> <i class="fa fa-eye"></i>  </a>
                                        </td>
                                        <td>
                                            <a href="/leaves/calendar/{{$leave->employee->id}}" class="btn-xs btn-success"> <i class="fa fa-eye"></i>  </a>
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
    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                           <h3><i class="fa fa-plus m-r-5"></i> Add Leave</h3>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal" action="/leaves/store" method="POST" >
                                     @csrf
                                    <fieldset>
                                       <!-- Text input-->
{{--                                       <div class="col-md-12 form-group">--}}
{{--                                          <label class="control-label">Employee Name</label>--}}
{{--                                          <input type="text" placeholder="Enter Name" name="leaveEmpyoeeName" class="form-control">--}}
{{--                                       </div>--}}
                                            <div class="col-md-12 form-group">
                                                <label>Employee Name</label>
                                                <select class="form-control" name="employeeid" id="employeeid">
                                                    <option>-- Select Employee --</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       <div class="col-md-6 form-group">
                                          <label class="control-label">From</label>
                                          <input type="datetime-local" placeholder="From" name="from" class="form-control">
                                       </div>
                                         <div class="col-md-6 form-group">
                                          <label class="control-label">To</label>
                                          <input type="datetime-local" placeholder="To" name="to" class="form-control">
                                       </div>

{{--                                       <div class="col-md-6 form-group">--}}
{{--                                          <label class="control-label">From Hour</label>--}}
{{--                                          <input type="time" name="startTime" placeholder="To Hour" class="form-control">--}}
{{--                                       </div>--}}
{{--                                         <div class="col-md-6 form-group">--}}
{{--                                          <label class="control-label">To Hour</label>--}}
{{--                                          <input type="time" name="endTime" placeholder="To Hour" class="form-control">--}}
{{--                                       </div>--}}
                                       <div class="col-md-12 form-group">
                                          <label class="control-label">Type</label>
                                          <select class="form-control" name="type">
                                             <option selected disabled> --Select Type--</option>
                                             <option>Personal Leave</option>
                                             <option>Sick Leave</option>
                                          </select>
                                       </div>
                                        <div class="col-md-12 form-group">
                                          <label class="control-label">Comment</label>
                                          <textarea placeholder="Comment" name="comment" class="form-control"></textarea>
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
