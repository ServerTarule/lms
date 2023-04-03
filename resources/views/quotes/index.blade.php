@extends('layout.app')
@section('title', 'Quotes')
@section('subtitle', 'List of Quotes')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd ">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Quotes</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addHoliday"><i class="fa fa-plus"></i> Add Quote</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="info">
                                <th>S. No.</th>
                                <th>Topic</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @foreach ($holidays as $holiday)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $loop->iteration }}</td>--}}
{{--                                    <td>{{ $holiday->name }}</td>--}}
{{--                                    <td>{{ \Carbon\Carbon::parse($holiday->day)->format('d/m/Y') }}</td>--}}
{{--                                    <td>{{ \Carbon\Carbon::parse($holiday->created_at)->format('d/m/Y') }}</td>--}}
{{--                                    <td>--}}
{{--                                        <a data-toggle="modal" data-target="#edititem" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a class="btn-xs btn-danger"> <i class="fa fa-trash-o"></i>  </a>--}}
{{--                                    </td>--}}
{{--                            @endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="modal fade" id="addHoliday" tabindex="-1" role="dialog" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header modal-header-primary">--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
{{--                    <h3><i class="fa fa-plus m-r-5"></i> Add Holiday</h3>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <form class="form-horizontal" action="{{ route('holidays.store') }}" method="POST">--}}
{{--                                @csrf--}}
{{--                                <fieldset>--}}
{{--                                    <!-- Text input-->--}}
{{--                                    <div class="col-md-8 form-group">--}}
{{--                                        <label class="control-label">Holiday Name</label>--}}
{{--                                        <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 form-group">--}}
{{--                                        <label class="control-label">Date</label>--}}
{{--                                        <input type="date" id="day" name="day" placeholder="dd/mm/yyyy" class="form-control">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12 form-group">--}}
{{--                                        <div>--}}
{{--                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>--}}
{{--                                            <button class="btn btn-add btn-sm">Save</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </fieldset>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
