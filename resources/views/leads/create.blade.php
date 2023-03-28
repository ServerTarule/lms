@extends('layout.app')
@section('title', 'Add Lead')
@section('subtitle', 'List of lead')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="viewLeadform.php" class="btn btn-exp btn-sm"><i class="fa fa-eye"></i> View Leads</a>
            </div>
{{--            <form  method="post" class="form-horizontal" action="/leads">--}}
{{--                @csrf--}}
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonexport">
                            <a href="#">
                                <h4>General Information</h4>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <div class="row">
                                <fieldset>
                                    <div class="form-group col-sm-5">
                                        <label>Name <span class="required"> * </span></label>
                                        <input class="form-control Reg" id="name" name="name" placeholder="Enter Name" required="required" type="text" value="" />
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Email Id</label>
                                        <input class="form-control EmailId" id="email" name="email" placeholder="Enter EmailId" type="text" value="" />
                                        <span class="required" id="rqrmail" style="color: red; width: -5%; display: none;"> Please Enter Valid Email </span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Mobile Number <span style="color: red;"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <input class="form-control Reg MobileNo" id="mobileno" name="mobileno" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter MobileNumber" required="required" type="text" value="" />
                                        <span class="required" id="rqrNumber" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number </span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="emp_name">Alternate MobileNo.</label>
                                        <input class="form-control AlterMobile_No" id="altmobileno" name="altmobileno" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter Mobile Number" type="text" value="" />
                                        <span class="required" id="rqrAlterNumber" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number</span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="emp_name">Received Date <span class="required"> * </span></label>
                                        <input
                                            autocomplete="off"
                                            class="form-control Date CurrentDate Reg hasDatepicker"
                                            data-val="true"
                                            data-val-date="The field ReceivedDate must be a date."
                                            id="receiveddate"
                                            name="receivedDate"
                                            placeholder="Enter Received Date"
                                            value="{{ now()->setTimezone('T')->format('Y-m-dTh:m') }}"
                                            type="datetime-local"
                                        />
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonexport">
                            <a href="#">
                                <h4>Other Information</h4>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <div class="row">
                                <fieldset>
                                    @foreach($masters as $master)
                                        <div class="form-group col-sm-3">
                                            <label>{{ $master->name }}{{--<span class="required"> * </span>--}}</label>
                                            <select class="form-control" name="leadMaster" id="leadMaster_{{ $master -> id }}">
                                                <option>-- Select Condition --</option>
                                                @php
                                                    $values = $master->values()->get();
                                                @endphp
                                                @foreach($values as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                    <div class="col-sm-12">
                                        <label>Remark</label>
                                        <div class="form-group">
                                            <textarea class="form-control Remark" cols="20" id="remark" name="remark" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" id="leadMasterSubmit" class="btn btn-primary btn-sm">Submit</button>
                                            <button type="reset" id="leadMasterReset" class="btn btn-danger btn-sm">Clear</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="leadMasters" id="leadMasters" value="{{ $masters }}">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
{{--            </form>--}}
        </div>
    </div>
@endsection
