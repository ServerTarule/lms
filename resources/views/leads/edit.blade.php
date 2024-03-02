@extends('layout.app')
@section('title', 'Edit Lead')
@section('subtitle', 'List of lead')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="/leads" class="btn btn-exp btn-sm"><i class="fa fa-eye"></i> View Leads</a>
            </div>
                <form  method="post" id="updateLeadForm" class="form-horizontal" enctype="multipart/form-data" >
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
                                            <label>Name <span class="text-danger required"> * </span></label>
                                            <input class="form-control Reg" id="name" name="name" placeholder="Enter Name" required="required" value="{{$lead->name}}" type="text" value="" />
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label>Email Id </label>
                                            <!-- <span class="text-danger required"> * </span> -->
                                            <input class="form-control EmailId" id="email" name="email" value="{{$lead->email}}" placeholder="Enter EmailId" type="text" value="" />
                                            <span class="required" id="rqrmail" style="color: red; width: -5%; display: none;"> Please Enter Valid Email </span>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label>Mobile Number <span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                            <input class="form-control Reg MobileNo"  max-length="10"  id="mobileno" name="mobileno" value="{{$lead->mobileno}}" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter MobileNumber" required="required" type="text" value="" />
                                            <span class="required" id="rqrNumber" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number </span>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="emp_name">Alternate MobileNo.</label>
                                            <input class="form-control AlterMobile_No" id="altmobileno" name="altmobileno" value="{{$lead->altmobileno}}" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter Mobile Number" type="text" value="" />
                                            <span class="required" id="rqrAlterNumber" max-length="10" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number</span>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="emp_name">Received Date <span class="text-danger required"> * </span></label>
                                            <input
                                                autocomplete="off"
                                                class="form-control Date CurrentDate Reg hasDatepicker"
                                                data-val="true"
                                                data-val-date="The field ReceivedDate must be a date."
                                                id="receiveddate"
                                                name="receiveddate"
                                                placeholder="Enter Received Date"
                                                value="{{$lead->receiveddate ?? now()->setTimezone('T')->format('Y-m-dTh:m')}}"
                                                type="datetime-local"
                                            />
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if($isFirstCalling)
                            <div class="panel-body">
                                <div  >      
                                    <h4>Upload File</h4>
                                    <div class="row">
                                        <fieldset>
                                            <div class="form-group col-sm-5">
                                                <span class="divupld">
                                                    <!-- <label for="myupld" class="myupldicon"><i class="fa fa-cloud-upload"></i></label> -->
                                                    <input type="file" id="myupld" multiple="multiple" />
                                                </span>
                                            </div>
                                        </fieldset>
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                            <div class="panel-body">
                                <div>      
                                    <h4>
                                        Center Change 
                                    </h4>
                                    <i class="fa fa-info-circle" title='To Change the center, Please select State & City to get the respective center(s)' aria-hidden="true"><i> To Change the center, Please select State & City to get the respective center(s)</i></i>
                                    <div class="row">
                                        <fieldset>
                                            <div class="form-group col-sm-5">
                                                <label>Name <span class="text-danger required"> * </span></label>
                                                <select class="form-control state-dropdown" name="state" id="state-dropdown" onchange="getCityForState(this.value)" rquired >
                                                    <option value="0">Select State </option>
                                                    @foreach ($state as $states )
                                                        @php
                                                            $selectedStateStr = "";
                                                            if(isset($lead->state) && $lead->state == $states->id ) {
                                                                $selectedStateStr = "selected";
                                                            }
                                                        @endphp
                                                        <option value="{{$states->id}}" {{$selectedStateStr}}>{{$states->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-5">
                                                <label class="control-label">City  <span class="required text-danger"> * </span></label>
                                                <select class="form-control city-dropdown" id="city-dropdown" name="city" onChange="getCenterForStateAndCity()" rquired >
                                                    <option value="0">Select City</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-5">
                                                <label class="control-label">Center Name/Detail  <span class="required text-danger"> * </span></label>
                                                <select class="form-control center-detail" id="center-detail" name="centerId" rquired >
                                                    <option value="0">Select Center</option>
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                         
                        @endif  
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
                                                <label>
                                                    {{ $master->name }}
                                                    @if(in_array($master->id, $masterIdsToMakeDynamic))
                                                        @php
                                                            
                                                            $parentMasterName = "";
                                                            if(isset($master) &&isset($master->id) && $master->id == 4) {
                                                                $parentMasterName = "Lead Status";
                                                            }
                                                            else {
                                                                $parentMasterName = "State";
                                                            }
                                                            
                                                        @endphp
                                                        <i class="fa fa-info-circle" title='Please select "{{$parentMasterName}}" value to get value in this dropdown.' aria-hidden="true"></i>
                                                    @endif
                                                    {{--<span class="required text-danger"> * </span>--}}
                                                </label>
                                                <select class="form-control" name="leadMaster" onChange="getDependentData(event)" data-masterid="{{$master->id}}" id="leadMaster_{{ $master -> id }}">
                                                    <option value="0">-
                                                        - Select {{ $master->name }} -- 
                                                    </option>
                                                    @if(isset($master) &&isset($master->id) && !in_array($master->id, $masterIdsToMakeDynamic))
                                                        @php
                                                            $values = $master->values()->get();
                                                        @endphp
                                                        @foreach($values as $value)
                                                            @php
                                                                $valueToSelect = (isset($leadMasterKeyValueArray) && count($leadMasterKeyValueArray) > 0)?$leadMasterKeyValueArray[$master->id]:"";
                                                                $selectedText = '';
                                                                $selectedText = $valueToSelect == $value->id ? 'selected' :'';
                                                            @endphp
                                                            <option value="{{ $value->id }}"  {{$selectedText}}>{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                        @endforeach
                                        <div class="col-sm-12">
                                            <label>Remark</label>
                                            <div class="form-group">
                                                <textarea class="form-control Remark" cols="20" id="remark" name="remark" rows="2">{{$lead->remark}}</textarea>
                                            </div>
                                        </div>
                                        <input class="leadId" type="hidden" id="leadId" value="{{$lead->id}}" name="leadId"  />
                                        <input type="hidden" name="leadMasters" id="leadMasters" value="{{ $masters }}">
                                        
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-sm-12">
                    <div class="form-group text-right">
                        <button type="button" id="leadMasterSubmitUpdate"  class="btn btn-primary btn-sm">Submit</button>
                        <button type="reset" id="leadMasterReset" class="btn btn-danger btn-sm">Clear</button>
                    </div>
                </div>
            </div>   
        </div>
    </div>
@endsection


@push('custom-scripts')
<script type="text/javascript">
    const masterDependentObj = {7:8,3:4};
    const isFirstCalling = {{Js::from($isFirstCalling)}};
    const state = {{Js::from($lead->state)}};
    const city = {{Js::from($lead->city)}};
    const selectedCenterId = {{Js::from($lead->center_id)}};
    const masterDependentObjName = {7:"Cities",3:'Lead Stages'};
    const leadMasterKeyValueArray =  {{ Js::from($leadMasterKeyValueArray) }};
</script>
<script type="text/javascript" src="{{ URL::asset('public//customjs/lead-edit.js') }}"></script>
@endpush
