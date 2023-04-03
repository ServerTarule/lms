@extends('layout.app')
@section('title', 'SMS/Email/WhatsApp Schedules')
@section('subtitle', 'List of Schedules')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Schedules</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i
                                class="fa fa-plus"></i> Schedule Action</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    <a>S.No.</a>
                                </th>
                                <th scope="col">
                                    <a>Rule</a>
                                </th>
                                <th scope="col">
                                    <a>Type</a>
                                </th>
                                <th scope="col">
                                    <a>Template Name</a>
                                </th>
                                <th scope="col">
                                    <a>Scheduled/Send Now</a>
                                </th>
                                <th scope="col">
                                    <a>Count</a>
                                </th>
                                <th scope="col">
                                    <a>Date</a>
                                </th>
                                <th scope="col">
                                    <a>Time</a>
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
                            <tr>
                                <td>1</td>
                                <td>Rule 1</td>
                                <td>xyz</td>
                                <td>SMS</td>
                                <td>Scheduled</td>
                                <td><a href="viewTemplate.php">2</a></td>
                                <td>26/12/2022</td>
                                <td>08:00AM</td>

                                <td>
                                    <a data-toggle="modal" data-target="#additem" class="btn-xs btn-info"> <i
                                            class="fa fa-edit"></i> <span>Edit</span> </a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Are you sure want to delete this?')"
                                       class="btn-xs btn-info" style="background: red;"> <i class="fa fa-trash-o"></i>
                                        <span>Delete</span> </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> SMS/Email/WhatsApp Template </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal">
                                <fieldset>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Rule</label>
                                        <select name="Type" class="form-control">
                                            <option value="0">--select Rule--</option>
                                            <option value="0">Rule 1</option>
                                            <option value="0">Rule 2</option>
                                        </select>

                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Type</label>
                                        <select name="Type" id="ddlDescription" class="form-control"
                                                onchange="getVal()">
                                            <option value="0">--select Type--</option>
                                            <option value="Email"> Email</option>
                                            <option value="SMS"> SMS</option>
                                            <option value="WhatsApp"> WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Template</label>
                                        <select name="Type" class="form-control">
                                            <option value="0">--select Template--</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Suject</label>
                                        <input type="text" name="" placeholder="Please type here.."
                                               class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group" id="Sms-WhatsApp">
                                        <label class="control-label" id="control-label">Sms/WhatsApp</label>
                                        <textarea class="form-control Comments"
                                                  placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-12 form-group" id="email">
                                        <label class="control-label">Email</label>
                                        <textarea class="form-control" id="Comments"
                                                  placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label"><input type="radio" value="scheduled" name="1"/>
                                            Scheduled</label>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label"><input type="radio" value="send-now" name="1"/>
                                            Send Now</label>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <select name="Type" class="form-control">
                                            <option value="0">--select--</option>
                                            <option> Every Month</option>
                                            <option> Every Week</option>
                                            <option> Every Second Week</option>
                                            <option> Daily</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <select name="Type" class="form-control">
                                            <option value="0">--Select Day--</option>
                                            <option> Sunday</option>
                                            <option> Monday</option>
                                            <option> Tuesday</option>
                                            <option> Wednesday</option>
                                            <option> Thursday</option>
                                            <option> Friday</option>
                                            <option> Saturday</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <select name="Type" class="form-control">
                                            <option value="0">--Select Date--</option>
                                            <option> 1</option>
                                            <option> 2</option>
                                            <option> 3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="time" name="" class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                Cancel
                                            </button>
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
@endsection
