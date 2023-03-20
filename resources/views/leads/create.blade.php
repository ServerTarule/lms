@extends('layout.app')
@section('title', 'Add Lead')
@section('subtitle', 'List of lead')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="viewLeadform.php" class="btn btn-exp btn-sm"><i class="fa fa-eye"></i> View Leads</a>
            </div>
            <form  method="post" class="form-horizontal" action="/leads">
                @csrf
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
                                        <input class="form-control Reg" id="Name" name="Name" placeholder="Enter Name" required="required" type="text" value="" />
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Email Id</label>
                                        <input class="form-control EmailId" id="EmailId" name="EmailId" placeholder="Enter EmailId" type="text" value="" />
                                        <span class="required" id="rqrmail" style="color: red; width: -5%; display: none;"> Please Enter Valid Email </span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Mobile Number <span style="color: red;"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <input class="form-control Reg MobileNo" id="MobileNo" maxlength="10" name="MobileNo" onkeypress="return isNumberKey(event)" placeholder="Enter MobileNumber" required="required" type="text" value="" />
                                        <span class="required" id="rqrNumber" style="color: red; width: -5%; display: none;"> Please Enter Currect Number </span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="emp_name">Alternate MobileNo.</label>
                                        <input class="form-control AlterMobile_No" id="AlternateMobno" maxlength="10" name="AlternateMobno" onkeypress="return isNumberKey(event)" placeholder="Enter Mobile Number" type="text" value="" />
                                        <span class="required" id="rqrAlterNumber" style="color: red; width: -5%; display: none;"> Please Enter Currect Number</span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="emp_name">Received Date <span class="required"> * </span></label>
                                        <input
                                            autocomplete="off"
                                            class="form-control Date CurrentDate Reg hasDatepicker"
                                            data-val="true"
                                            data-val-date="The field ReceivedDate must be a date."
                                            id="ReceivedDate"
                                            name="ReceivedDate"
                                            placeholder="Enter Received Date"
                                            type="text"
                                            value=""
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
                                    <div class="form-group col-sm-3">
                                        <label>Treatment Type<span class="required"> * </span></label>
                                        <select class="form-control" data-val="true" data-val-number="The field TreatmentType must be a number." id="TreatmentType" name="TreatmentType">
                                            <option value="">--Select TeatmentType--</option>
                                            <option value="19">PRK or ASA</option>
                                            <option value="20">CATARACT</option>
                                            <option value="21">CONTOURA VISION</option>
                                            <option value="22">Implantable Contact Lens (ICL)</option>
                                            <option value="23">LASIK &amp; ICL</option>
                                            <option value="24">SQUINT</option>
                                            <option value="25">RELEX SMILE</option>
                                            <option value="26">LASIK &amp; SQUINT</option>
                                            <option value="27">PRESBYOPIA</option>
                                            <option value="28">LASIK</option>
                                            <option value="29">Blade-Free Lasik</option>
                                            <option value="30">SBK Lasik</option>
                                            <option value="31">Not Applicable (NA)</option>
                                            <option value="32">OTHERS</option>
                                            <option value="33">C3R Surgery</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Case Type<span class="required"> * </span></label>
                                        <select class="form-control" data-val="true" data-val-number="The field CaseType must be a number." id="CaseType" name="CaseType">
                                            <option value="1">Fresh Call</option>
                                            <option value="2">2nd Option</option>
                                            <option value="4">Repeated</option>
                                            <option value="8">3rd Option</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Source<span class="required"> * </span></label>
                                        <select class="form-control" data-val="true" data-val-number="The field Source must be a number." id="Source" name="Source">
                                            <option value="">--Select Source--</option>
                                            <option value="1">CALL</option>
                                            <option value="2">MAIL</option>
                                            <option value="3">Tawk-To</option>
                                            <option value="4">Whatsapp</option>
                                            <option value="5">Reference</option>
                                            <option value="6">Tawk &amp; Mail</option>
                                            <option value="7">JustDial</option>
                                            <option value="8">IVR Call</option>
                                            <option value="9">SMS Campaign</option>
                                            <option value="10">Mail Campaign</option>
                                            <option value="11">Old Case</option>
                                            <option value="12">Social Media</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Case Status<span class="required"> * </span></label>
                                        <select class="form-control" data-val="true" data-val-number="The field ConnectStatus must be a number." id="ConnectStatus" name="ConnectStatus">
                                            <option value="3">InProcess</option>
                                        </select>
                                    </div>
        {{--                            <div class="form-group col-sm-3">
                                        <label>State <span class="required"> * </span><span class="spanstate required"></span></label>
                                        <input autocomplete="off" class="form-control StateName Reg ui-autocomplete-input" data-val="true" data-val-number="The field State must be a number." id="State" name="State" placeholder="Enter State" type="text" value="" />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                        <input type="hidden" class="hdnstateid" value="0" name="hdnstateid" />
                                    </div>--}}
                                    <div class="form-group col-sm-3">
                                        <label>State <span class="required"> * </span><span class="spanstate required"></span></label>
                                        <select class="form-control" data-val="true" id="state" name="State">
                                            <option selected disabled>-- Select State --</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state -> id }}">{{ $state -> name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>City </label>
                                        <input autocomplete="off" class="form-control CityName ui-autocomplete-input" data-val="true" data-val-number="The field City must be a number." id="City" name="City" placeholder="Enter City" type="text" value="" />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                        <input type="hidden" class="hdncityid" value="0" name="hdncityid" />
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Location </label>
                                        <input autocomplete="off" class="form-control Location ui-autocomplete-input" id="Location" name="Location" placeholder="Enter Location" type="text" value="" />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span> <input type="hidden" class="CenterRecommended ui-autocomplete-input" name="CenterRecommended" autocomplete="off" />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Max/Per Day </label>
                                        <input autocomplete="off" class="form-control Location ui-autocomplete-input" id="Max-Per-Day" name="Location" placeholder="Max/Per Day" type="text" value="" />
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Max/Per Week </label>
                                        <input autocomplete="off" class="form-control Location ui-autocomplete-input" id="Max-Per-Week" name="Location" placeholder="Max/Per Week" type="text" value="" />
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Location </label>
                                        <input autocomplete="off" class="form-control Location ui-autocomplete-input" id="Location" name="Location" placeholder="Enter Location" type="text" value="" />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span> <input type="hidden" class="CenterRecommended ui-autocomplete-input" name="CenterRecommended" autocomplete="off" />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Master 1 <span class="required"> * </span></label>
                                        <select class="form-control" name="ConnectStatus">
                                            <option value="1">jitender</option>
                                            <option value="2">sagar</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Master 2 <span class="required"> * </span></label>
                                        <select class="form-control" name="ConnectStatus">
                                            <option value="1">abc</option>
                                            <option value="2">xyz</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Master 3 <span class="required"> * </span></label>
                                        <select class="form-control" name="ConnectStatus">
                                            <option value="1">xyz</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Remark</label>
                                        <div class="form-group">
                                            <textarea class="form-control Remark" cols="20" id="Remark" name="Remark" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-sm">Clear</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
