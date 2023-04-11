@extends('layout.app')
@section('title', 'First Calling')
@section('subtitle', 'Call Details')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="tblheadclr1" style="text-align: center;">
                        <th>Name</th>
                        <th>EmailId</th>
                        <th>Mobile No</th>
                        <th>Treatment Type</th>
                        <th>Lead Type</th>
                        <th>Lead Status</th>
                        <th>Lead Stage</th>
                        <th>Source</th>
                        <th>Action Types</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Assigned By</th>
                        <th>Center Recommended</th>
                        <th>Center Change</th>
                        <th>Edit</th>
                        <th>Upload</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                @foreach ($leadKV as $key => $value)
                    <td>{{$value}}</td>
                @endforeach
                    <td></td>
                    <td></td>
                    <td>
                        <a class="btn btn-primary CenterRecommended" data-toggle="modal" data-target="#CenterChange" style="cursor: pointer;"><span>Center Change</span></a>
                        <input type="hidden" class="ModuleName" value="FirstCallingDetails" />
                        <input type="hidden" id="leadId" name="leadId" value="{{$leadKVForEdit['id']}}" />
                    </td>
                    <td>
                        <a data-toggle="modal" data-target="#editLead" id="editLeadDetails" class="btn btn-primary" style="cursor: pointer;"><i class="fa fa-edit"></i></a>
                    </td>
                    <td>
                        <span class="divupld">
                            <label for="myupld" class="myupldicon"><i class="fa fa-cloud-upload"></i></label>
                            <input type="file" id="myupld" multiple="" />
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="form-group col-sm-4">
            <label>Owner Name</label>
                <select class="form-control" name="leadEmployeeId" id="leadEmployeeId">
                    <option value="">-- Select Owner --</option>
                    @foreach ($employees as $employee )
                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="col-sm-4">
            <label>Call Status</label> <span class="required" id="LeadStatus" style="color: red; width: -5%; float: right;"> </span>
            <div class="form-group">
                <select class="form-control CallingSubject" name="callStatusId" id="callStatusId" >
                    <option value="">-- Select Call Status --</option>
                    @foreach ($callStatusValues as $callstatus )
                        <option value="{{$callstatus->id}}">{{$callstatus->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <label>Next Reminder Date</label>
            <div class="form-group">
                <input type="date" class="form-control NextReminderDate reg" id="leadNextReminderDate" name="leadNextReminderDate" placeholder="dd/mm/yyyy" autocomplete="off" />
            </div>
        </div>
        <div class="col-sm-12 form-group">
            <label>Description</label>
            <div class="form-group">
                <textarea class="form-control" id="leadCallRemark" name="leadCallRemark"></textarea>
            </div>
        </div>
        <div class="col-sm-12 form-group">
            <div class="form-group">
                <a id="leadFollowup" class="btn btn-sm btn-primary">Follow Up</a>
                <a data-toggle="modal" data-target="#sendEmail" class="btn btn-sm btn-primary">Send Email</a>
                <a data-toggle="modal" data-target="#sendWhatsApp" class="btn btn-sm btn-primary">Send WhatsApp</a>
                <a class="btn btn-sm btn-success" type="submit">Submit</a>
                <a class="btn btn-sm btn-info" href="/leads/calls">< Back</a>
            </div>
        </div>
        <div class="col-lg-12">
            <table class="table table-bordered table-striped table-hover" id="table">
                <thead>
                <tr class="tblheadclr2" style="text-align: center;">
                    <th>S.No</th>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Calling Date</th>
                    <th>Lead Status</th>
                    <th>Next Reminder Date</th>
                    <th>Remark</th>
                    <th>Call Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($leadCalls as $leadCall)
                    <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $leadCall->employee?->name }}</td>
                            <td>{{ $leadCall->type }}</td>
                            <td>{{ \Carbon\Carbon::parse($leadCall->called_at)->format('d/m/Y') }}</td>
                            <td>{{ $leadCall->leadstatus?->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($leadCall->remind_at)->format('d/m/Y') }}</td>
                            <td>{{ $leadCall->remark }}</td>
                            <td>{{ $leadCall->callstatus->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="CenterChange" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i>Center Change</h3>
                </div>
                <div class="modal-body">
                    <form action="/Lead/ChangeCenter" method="post">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>State <span class="spnrecommendedstate required"></span></label>
                                    <select class="form-control StateName">
                                        <option value="0">--Select State--</option>
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
                                        <option value="25" selected="">PUNJAB</option>
                                        <option value="26">RAJASTHAN</option>
                                        <option value="27">SIKKIM</option>
                                        <option value="28">TAMIL NADU</option>
                                        <option value="29">TELANGANA</option>
                                        <option value="30">TRIPURA</option>
                                        <option value="31">UTTAR PRADESH</option>
                                        <option value="32">UTTARAKHAND</option>
                                        <option value="33">WEST BENGAL</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>City <span class="spnrecommendedcity required"></span></label>
                                    <select class="form-control CityName">
                                        <option value="0">--Select City--</option>
                                        <option value="836">ABOHAR</option>
                                        <option value="804">AMRITSAR</option>
                                        <option value="791">ANANDPUR SAHIB</option>
                                        <option value="825">BARNALA</option>
                                        <option value="805">BATALA</option>
                                        <option value="828">BATHINDA</option>
                                        <option value="801">BHADAUR</option>
                                        <option value="829">BUDHLADA</option>
                                        <option value="813">DASUYA</option>
                                        <option value="797">DEHLON</option>
                                        <option value="822">DHURI</option>
                                        <option value="818">DINANAGAR</option>
                                        <option value="827">FARIDKOT</option>
                                        <option value="837">FAZILKA</option>
                                        <option value="833">FIROZPUR</option>
                                        <option value="815">GARHSHANKER</option>
                                        <option value="842">GIDDARBAHA</option>
                                        <option value="808">GURDASPUR</option>
                                        <option value="810">HOSHIARPUR</option>
                                        <option value="841">JAGRAON</option>
                                        <option value="832">JALALABAD</option>
                                        <option value="809" selected="">JALANDHAR</option>
                                        <option value="831">JHUNIR</option>
                                        <option value="806">KAPURTHALA</option>
                                        <option value="840">KHANNA</option>
                                        <option value="803">KOTKAPURA</option>
                                        <option value="793">LALRU</option>
                                        <option value="795">LUDHIANA</option>
                                        <option value="839">MACHHIWARA</option>
                                        <option value="798">MALERKOTLA</option>
                                        <option value="835">MALOUT</option>
                                        <option value="799">MANDI GOBINDGARH</option>
                                        <option value="830">MANSA</option>
                                        <option value="800">MOGA</option>
                                        <option value="814">MUKERIAN</option>
                                        <option value="834">MUKTSAR</option>
                                        <option value="838">NABHA</option>
                                        <option value="812">NAKODAR</option>
                                        <option value="816">NAWANSHAHR</option>
                                        <option value="817">PATHANKOT</option>
                                        <option value="821">PATIALA</option>
                                        <option value="820">PATRAN</option>
                                        <option value="807">PATTI</option>
                                        <option value="811">PHAGWARA</option>
                                        <option value="796">RAIKOT</option>
                                        <option value="794">RAJPURA</option>
                                        <option value="826">RAMPURA PHUL</option>
                                        <option value="790">RUPNAGAR</option>
                                        <option value="819">SAMANA</option>
                                        <option value="823">SANGRUR</option>
                                        <option value="792">SIRHIND-FATEGARH</option>
                                        <option value="824">SUNAM</option>
                                        <option value="843">TARN TARAN SAHIB</option>
                                        <option value="802">ZIRA</option>
                                        <option value="844">ZIRAKPUR</option>
                                    </select>
                                </div>
                                <br />
                                <div class="col-md-12">
                                    <label>Center Recommended</label>
                                    <input type="text" class="form-control CenterRecommended ui-autocomplete-input" name="CenterRecommended" id="CenterRecommended" value="PEC" autocomplete="off" />
                                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    <span id="cntmsg" class="cntmsg" style="display: none; color: red;">Any Center Recommended Not Be Found !!</span>
                                </div>
                                <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px;">
                                    <div class="">
                                        <input style="font-weight: bold;" type="submit" class="btn btn-primary mybtn" value="Submit" id="btnsubmit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editLead" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i>Edit Lead</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal"  action="{{ route('leads.update', $leadKVForEdit['id']) }}" method="POST">
                                @csrf
                                <input type="hidden" id="leadId" name="leadId" value="{{$leadKVForEdit['id']}}" />
                                <div class="col-md-12">
                                    <h4 style="text-align: left; font-weight: bold; color: #00b0f0; text-decoration: underline;">General Information</h4>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label>Name <span class="required"> * </span></label>
                                            <input class="form-control Reg" id="leadName" name="leadName" placeholder="Enter Name" required="required" type="text" value="{{ $leadKVForEdit['name'] }}" />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Email Id</label>
                                            <input class="form-control EmailId" id="leadEmail" name="leadEmail" placeholder="Enter EmailId" type="text" value="{{ $leadKVForEdit['email'] }}" />
                                            <span class="required" id="rqrmail" style="color: red; width: -5%; display: none;"> Please Enter Valid Email </span>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>Mobile Number <span style="color: red;"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                            <input
                                                class="form-control Reg MobileNo"
                                                id="leadMobile"
                                                maxlength="10"
                                                name="leadMobile"
                                                onkeypress="return isNumberKey(event)"
                                                placeholder="Enter MobileNumber"
                                                required="required"
                                                type="text"
                                                value="{{ $leadKVForEdit['mobileno'] }}"
                                            />
                                            <span class="required" id="rqrNumber" style="color: red; width: -5%; display: none;"> Please Enter Currect Number </span>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="emp_name">Alternate MobileNo.</label>
                                            <input
                                                class="form-control AlterMobile_No"
                                                id="leadAlternateMobile"
                                                maxlength="10"
                                                name="leadAlternateMobile"
                                                onkeypress="return isNumberKey(event)"
                                                placeholder="Enter Mobile Number"
                                                type="text"
                                                value="{{$leadKVForEdit['altmobileno']}}"
                                            />
                                            <span class="required" id="rqrAlterNumber" style="color: red; width: -5%; display: none;"> Please Enter Currect Number</span>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="emp_name">Received Date <span class="required"> * </span></label>
                                            <input
                                                readonly
                                                autocomplete="off"
                                                class="form-control Date Reg hasDatepicker"
                                                data-val="true"
                                                data-val-date="The field ReceivedDate must be a date."
                                                id="leadReceivedDate"
                                                name="leadReceivedDate"
                                                placeholder="Enter Received Date"
                                                type="text"
                                                value="{{ \Carbon\Carbon::parse($leadKVForEdit['receiveddate'])->format('d/m/Y') }}"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4 style="text-align: left; font-weight: bold; color: #00b0f0; text-decoration: underline;">Other Information</h4>
                                    <div class="row">
                                        @foreach($masters as $master)
                                            <div class="form-group col-sm-6">
                                                <label>{{ $master->name }}<span class="required"> * </span></label>
                                                <select class="form-control" name="leadMaster_{{ $master -> id }}" id="leadMaster_{{ $master -> id }}">
                                                    <option value="NA">-- Select Option --</option>
                                                    @php
                                                        $values = $master->values()->get();
                                                    @endphp
                                                    @foreach($values as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label>Remark</label>
                                    <div class="form-group">
                                        <textarea class="form-control Remark" cols="20" id="leadRemark" name="leadRemark" rows="2">{{ $leadKVForEdit['remark'] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div>
                                            <input type="submit" class="btn btn-primary" value="Update" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:750px;width:100%">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-envelope m-r-5"></i> Send Email</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
{{--                            <form class="form-horizontal" action="{{ route('leads.email', $leadKV['id']) }}" method="POST">--}}
{{--                                @csrf--}}
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <select name="leadEmailTemplateId" id="leadEmailTemplateId" class="form-control" >
                                            <option value="NA">-- Select Template --</option>
                                            @foreach($emailTemplates as $emailTemplate)
                                                <option value="{{ $emailTemplate->id }}">{{ $emailTemplate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="email" placeholder="Enter Email Id" id="leadEmailId" name="leadEmailId" value="{{$leadKV['email']}}" class="form-control" />
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="text" placeholder="Subject" id="leadEmailSubject" name="leadEmailSubject" class="form-control" />
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea placeholder="Description" id="leadEmailBody" name="leadEmailBody" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="submit" class="btn btn-add btn-sm" id="leadSendEmail">Send</button>
                                        </div>
                                    </div>
                                </fieldset>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendWhatsApp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:750px;width:100%">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-whatsapp m-r-5"></i> Send WhatsApp</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
{{--                            <form class="form-horizontal" action="{{ route('leads.whatsapp', $leadKV['id']) }}" method="POST">--}}
{{--                                @csrf--}}
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <select name="leadWhatsAppTemplateId" id="leadWhatsAppTemplateId" class="form-control" >
                                            <option value="NA">-- Select Template --</option>
                                            @foreach($whatsappTemplates as $whatsappTemplate)
                                                <option value="{{ $whatsappTemplate->id }}">{{ $whatsappTemplate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input placeholder="Enter Mobile Number Ex: +91-0000000000" name="leadWhatsAppMobileNo" id="leadWhatsAppMobileNo" value="{{$leadKV['mobileno']}}" class="form-control" />
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea placeholder="Description" class="form-control" name="leadWhatsAppMessage" id="leadWhatsAppMessage"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="submit" class="btn btn-add btn-sm" id="leadSendWhatsApp">Send</button>
                                        </div>
                                    </div>
                                </fieldset>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
