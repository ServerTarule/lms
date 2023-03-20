@extends('layout.app')
@section('title', 'Action Type')
@section('subtitle', 'List of Action Types')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Action Type Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                    <div class="text-right">
                        <a href="#" class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i class="fa fa-plus"></i> Add Items</a>
                    </div>
                    <!-- ./Plugin content:powerpoint,txt,pdf,png,word,xl -->
                    <div class="table-responsive">

                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
                                <th scope="col">
                                    Action Type
                                </th>
                                <th scope="col">
                                    Created Date
                                </th>
                                <th scope="col">
                                    Edit
                                </th>
                                <th scope="col">
                                    Delete
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($actions as $action)
                                <tr>
                                    <td>{{$action->id}}</td>
                                    <td>{{$action->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($action->created_at)->format('d/m/Y')}}</td>
                                    <td>
                                        <a onclick="CheckStockStatus(19);" href="#" class="btn-xs btn-info"> <i class="fa fa-edit"></i> <span>Edit</span> </a>
                                    </td>
                                    <td>
                                        <a href="/Home/Deletetemp?Id=19 " onclick="return confirm('Are you sure want to delete this?')" class="btn-xs btn-info" style="background: red;"> <i class="fa fa-trash-o"></i> <span>Delete</span> </a>
                                    </td>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- items Modal1 -->
    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Add Action Type</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Action Type</label>
                                        <input type="text" placeholder="Enter Action Type" class="form-control">
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
