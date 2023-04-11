@extends('layout.app')
@section('title', 'SMS/Email/WhatsApp Schedules')
@section('subtitle', 'List of Schedules')
@section('content')
    <div class="row">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonexport">
                            <a href="#">
                                <h4>TEMPLATE STATUS</h4>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="text-right">
                            <a class="btn btn-exp btn-sm" href="/communications">< Back</a>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a>S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Mobile</a>
                                    </th>
                                    <th scope="col">
                                        <a>Email</a>
                                    </th>
                                    <th scope="col">
                                        <a>Lead Id</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($leads as $lead)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lead->name }}</td>
                                        <td>{{ $lead->mobileno }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td><a href="/leads/show/{{$lead->id}}">PID_{{ $lead->id }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
