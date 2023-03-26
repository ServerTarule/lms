@extends('layout.app')
@section('title', 'Employee Permissions Management')
@section('subtitle', 'List of Permissions')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Permissions Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option selected disabled>--Select Designation--</option>
                                                    <option>Manager</option>
                                                    <option>Employee</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="User Name" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-primary btn-submit bg-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    <a>S. No.</a>
                                </th>
                                <th scope="col">
                                    <a>Designation</a>
                                </th>
                                <th scope="col">
                                    <a>Employee Name</a>
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
                            @if($employees)
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->designation->name }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="/employees/permissions/{{$employee->id}}" class="btn-xs btn-info"> <i
                                                    class="fa fa-edit"></i> </a>
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Are you sure want to delete this?')"
                                               class="btn-xs btn-info" style="background: red;"> <i
                                                    class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
