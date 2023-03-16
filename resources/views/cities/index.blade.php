@extends('layout.app')
@section('title', 'Cities')
@section('subtitle', 'List of cities')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>City Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a  class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i class="fa fa-plus"></i> Add City</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
                                <th scope="col">
                                    <a>State</a>
                                </th>
                                <th scope="col">
                                    <a>City</a>
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
                            @foreach ($cities as $city)
                                <tr>
                                    <td>{{$city->id}}</td>
                                    <td>{{$city->state->name}}</td>
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->created_at}}</td>
                                    <td></td>
                                    <td></td>
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
                    <h3><i class="fa fa-plus m-r-5"></i> Add City </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="emp_mail">State <span class="required" style="color:red;"> * </span></label>

                                                <select class="form-control" data-val="true" data-val-number="The field StateId must be a number." id="StateId" name="StateId">
                                                    <option value="">--Select State--</option>
                                                    <option value="1">ANDAMAN AND NICOBAR</option>
                                                    <option value="2">ANDHRA PRADESH</option>
                                                    <option value="3">ARUNACHAL PRADESH</option>
                                                    <option value="4">ASSAM</option>
                                                    <option value="5">BIHAR</option>
                                                    <option value="6">CHANDIGARH</option>
                                                    <option value="7">CHHATTISGARH</option>
                                                    <option value="8">DAMAN AND DIU</option>
                                                    <option value="9">DELHI</option>
                                                    <option value="10">GOA</option>
                                                    <option value="11">GUJARAT</option>
                                                    <option value="12">HARYANA</option>
                                                    <option value="13">HIMACHAL PRADESH</option>
                                                    <option value="14">JAMMU AND KASHMIR</option>
                                                    <option value="15">JHARKHAND</option>
                                                    <option value="16">KARNATAKA</option>
                                                    <option value="17">KERALA</option>
                                                    <option value="18">MADHYA PRADESH</option>
                                                    <option value="19">MAHARASHTRA</option>
                                                    <option value="20">MEGHALAYA</option>
                                                    <option value="21">MIZORAM</option>
                                                    <option value="22">NAGALAND</option>
                                                    <option value="23">ORISSA</option>
                                                    <option value="24">PONDICHERRY</option>
                                                    <option value="25">PUNJAB</option>
                                                    <option value="26">RAJASTHAN</option>
                                                    <option value="27">SIKKIM</option>
                                                    <option value="28">TAMIL NADU</option>
                                                    <option value="29">TELANGANA</option>
                                                    <option value="30">TRIPURA</option>
                                                    <option value="31">UTTAR PRADESH</option>
                                                    <option value="32">UTTARAKHAND</option>
                                                    <option value="33">WEST BENGAL</option>
                                                </select>

                                                <label for="emp_mail">City <span class="required" style="color:red;"> * </span></label>
                                                <input required="Required" class="form-control" id="City" maxlength="100" name="City" placeholder="Enter City" type="text" value="">
                                            </div>
                                        </div>
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
    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> edit City </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="emp_mail">State <span class="required" style="color:red;"> * </span></label>

                                                <select class="form-control" data-val="true" data-val-number="The field StateId must be a number." id="StateId" name="StateId">
                                                    <option value="">--Select State--</option>
                                                    <option value="1">ANDAMAN AND NICOBAR</option>
                                                    <option value="2">ANDHRA PRADESH</option>
                                                    <option value="3">ARUNACHAL PRADESH</option>
                                                    <option value="4">ASSAM</option>
                                                    <option value="5">BIHAR</option>
                                                    <option value="6">CHANDIGARH</option>
                                                    <option value="7">CHHATTISGARH</option>
                                                    <option value="8">DAMAN AND DIU</option>
                                                    <option value="9">DELHI</option>
                                                    <option value="10">GOA</option>
                                                    <option value="11">GUJARAT</option>
                                                    <option value="12">HARYANA</option>
                                                    <option value="13">HIMACHAL PRADESH</option>
                                                    <option value="14">JAMMU AND KASHMIR</option>
                                                    <option value="15">JHARKHAND</option>
                                                    <option value="16">KARNATAKA</option>
                                                    <option value="17">KERALA</option>
                                                    <option value="18">MADHYA PRADESH</option>
                                                    <option value="19">MAHARASHTRA</option>
                                                    <option value="20">MEGHALAYA</option>
                                                    <option value="21">MIZORAM</option>
                                                    <option value="22">NAGALAND</option>
                                                    <option value="23">ORISSA</option>
                                                    <option value="24">PONDICHERRY</option>
                                                    <option value="25">PUNJAB</option>
                                                    <option value="26">RAJASTHAN</option>
                                                    <option value="27">SIKKIM</option>
                                                    <option value="28">TAMIL NADU</option>
                                                    <option value="29">TELANGANA</option>
                                                    <option value="30">TRIPURA</option>
                                                    <option value="31">UTTAR PRADESH</option>
                                                    <option value="32">UTTARAKHAND</option>
                                                    <option value="33">WEST BENGAL</option>
                                                </select>

                                                <label for="emp_mail">City <span class="required" style="color:red;"> * </span></label>
                                                <input required="Required" class="form-control" id="City" maxlength="100" name="City" placeholder="Enter City" type="text" value="">
                                            </div>
                                        </div>
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
@endsection
