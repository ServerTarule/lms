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
                        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload"><i class="fa fa-upload"></i> Bulk Upload</a>
                        <a href="addleadform.php" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add lead</a>

                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
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
                                    <a>Master 1</a>
                                </th>
                                <th scope="col">
                                    <a>Master 2</a>
                                </th>
                                <th scope="col">
                                    <a>Master 3</a>
                                </th>
                                <th scope="col">
                                    <a>Treatment Type</a>
                                </th>
                                <th scope="col">
                                    <a>Case Type</a>
                                </th>
                                <th scope="col">
                                    <a>Social Integration</a>
                                </th>
                                <th scope="col">
                                    <a>Location</a>
                                </th>
                                <th scope="col">
                                    <a>Case Status</a>
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
