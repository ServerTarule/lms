@extends('layout.app')
@section('title', 'Lead Assigning')
@section('subtitle', 'List of Lead Assigned')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                        <h4>View Leads</h4>
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="Name" name="Name">
                                    <option value="">--Select Owner--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="TreatmentType" name="TreatmentType">
                                    <option value="">--Select TeatmentType--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="CaseType" name="CaseType">
                                    <option value="">--Select CaseType--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="Source" name="Source">
                                    <option value="">--Select Source--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="ConnectStatus" name="ConnectStatus">
                                    <option value="">--Select Case Status--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="CenterDetails" name="CenterDetails">
                                    <option value="">--Select CenterRecommended--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <select class="form-control" id="CallingSubjectMaster" name="CallingSubjectMaster">
                                    <option value="">--Select Lead Status--</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-10">
                                <div class="text-right">
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</a>
                                    <a href="#" class="btn btn-info btn-sm"><i class="fa fa-file"></i> Excel</a>
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i> Clear</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Lead Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <div class="text-right">
                                <form action="edit_package.php" method="post">
                                    <div class="row">
                                        <div class="col-md-12 form-group AUTHORITY">
                                            <select class="form-control" id="AssignEmp" name="AssignEmp">
                                                <option value="">--Select Owner Name--</option>
                                            </select>
                                            <div>
                                                <button type="submit" class="btn btn-add">Assign Owner</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4"> <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#upload"><i class="fa fa-close"></i> Remove Owner</a></div>
                    </div>
                    <div class="text-right">
                        <a href="#" class="btn btn-success btn-sm btn-exp" data-toggle="modal" data-target="#upload"><i class="fa fa-upload"></i> Bulk Upload</a>
                        <a href="addleadform.php" class="btn btn-exp btn-sm"><i class="fa fa-plus"></i> Add lead</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col"></th>
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
                                    <a>Case Status</a>
                                </th>
                                <th scope="col">
                                    <a>CaseType</a>
                                </th>
                                <th scope="col">
                                    <a>Received Date</a>
                                </th>
                                <th scope="col">
                                    <a>Source</a>
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
                                    <a>TreatmentType</a>
                                </th>
                                <th scope="col">
                                    <a>Location</a>
                                </th>
                                <th scope="col">
                                    <a>Center Recommended</a>
                                </th>
                                <th scope="col">
                                    <a>Lead Status</a>
                                </th>
                                <th scope="col">
                                    <a>Latest Remark</a>
                                </th>
                                <th scope="col">
                                    <a>File</a>
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
