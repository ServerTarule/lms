@extends('layout.app')
@section('title', 'View Lead Form')
@section('subtitle', 'List of leads')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                        <h4>Lead Status</h4>
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="text-center">
                        <a onclick="document.getElementById('modal-18').classList.toggle('transformX-0');" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Filter</a>
                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload"><i class="fa fa-upload"></i> Bulk Upload</a>
                        <a href="/leads/create" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add lead</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
{{--                                <th scope="col">--}}
{{--                                    <a>Lead Id</a>--}}
{{--                                </th>--}}
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
{{--                                    <td>{{$lead->lead_id}}</td>--}}
                                    <td>{{$lead->name}}</td>
                                    <td>{{$lead->email}}</td>
                                    <td>{{$lead->mobileno}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead->receiveddate)->format('d/m/Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d/m/Y')}}</td>
                                    <td>
                                        <a href="/leads/{{$lead->id}}" class="btn-xs btn-info"> <i
                                                class="fa fa-edit"></i> </a>
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
{{--                                        <input type="file" name="file"  placeholder="Enter Source " class="form-control">--}}
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
@endsection
