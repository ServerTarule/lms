@extends('layout.app')
@section('title', 'Add Lead')
@section('subtitle', 'List of lead')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="/leads" class="btn btn-exp btn-sm"><i class="fa fa-eye"></i> View Leads</a>
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
                                        <label>Name <span class="text-danger required"> * </span></label>
                                        <input class="form-control Reg" id="name" name="name" placeholder="Enter Name" required="required" type="text" value="" />
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Email Id </label>
                                        <!-- <span class="text-danger required"> * </span> -->
                                        <input class="form-control EmailId" id="email" name="email" placeholder="Enter EmailId" type="text" value="" />
                                        <span class="required" id="rqrmail" style="color: red; width: -5%; display: none;"> Please Enter Valid Email </span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label>Mobile Number <span class="text-danger required"> * </span> <span class="spnmobile" style="color: red;"></span></label>
                                        <input class="form-control Reg MobileNo"  max-length="10"  id="mobileno" name="mobileno" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter MobileNumber" required="required" type="text" value="" />
                                        <span class="required" id="rqrNumber" style="color: red; width: -5%; display: none;"> Please Enter Mobile Number </span>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <label for="emp_name">Alternate MobileNo.</label>
                                        <input class="form-control AlterMobile_No" id="altmobileno" name="altmobileno" maxlength="10" {{--onkeypress="return isNumberKey(event)"--}} placeholder="Enter Mobile Number" type="text" value="" />
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
                                            <label>
                                                {{ $master->name }}
                                                
                                                @if(in_array($master->id, $masterIdsToMakeDynamic))
                                                    @php
                                                        
                                                        $parentMasterName = "";
                                                        if($master->id == 4) {
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
                                                @if(!in_array($master->id, $masterIdsToMakeDynamic))
                                                    @php
                                                        $values = $master->values()->get();
                                                    @endphp
                                                    @foreach($values as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
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


@push('custom-scripts')
<script type="text/javascript">

    const masterDependentObj = {7:8,3:4};
    const masterDependentObjName = {7:"City",3:'Lead Stages'};
    function getDependentData (event,masterName){
        const selectElement = event.target;
        const parentId = selectElement.value;
        const masterId = $(selectElement).data('masterid');
        const dependentId = masterDependentObj[masterId];
        const dependentName = masterDependentObjName[masterId];
        const dependentElementId =  `leadMaster_${dependentId}`;
        if(parseInt(parentId) > 0) {
            const optionBlank = `<option value="0">--Select value---</option>`;
            $(`#${dependentElementId}`).html(`${optionBlank}`);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/getDependentMaster',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'parentId': parentId
                },
                dataType: 'JSON',
                success: function (result) {
                    let dependentValues = [];
                    if(result?.dependentValues) {
                        dependentValues = result?.dependentValues??[];
                        dependentValues.forEach(dependentValue=>{
                            const option = `<option value="${dependentValue.id}">${dependentValue.name}</option>`;
                            $(`#${dependentElementId}`).append(`${option}`);
                        })
                    }
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching related data!');
                }
            });
        }
    }

    function getCityForState(stateId, cityId=0) {
        const firstOption = `<option value="0">Select City</option> `;
        $("#leadMaster_8").html(`${firstOption}`);
        if(parseInt(stateId) > 0) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/getcitiesBystate',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'stateId': stateId
                },
                dataType: 'JSON',
                success: function (result) {
                    let cities = [];

                    if(result?.cities) {
                        cities = result?.cities??[];
                        cities.forEach(city=>{
                            const option = `<option value="${city.id}">${city.name}</option>`;
                            $("#leadMaster_8").append(`${option}`);
                        })
                    }
                    if(cityId > 0) {
                        $("#leadMaster_8").val(cityId);
                    }
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching city data!');
                }
            });
        }
    }

    function validateForm() {
        let name = $('#name').val();
        let email = $('#email').val();
        let mobileno = $('#mobileno').val();
        let receiveddate = $('#receiveddate').val();
        let isValid = true;
        let validationError = "";
        if(!name || name == null) {
            validationError += `<li>Name field is mandatory field.</li>`;
            isValid =false;
        }
        // if(!email || email == null) {
        //     validationError += `<li>Email field is mandatory field.</li>`;
        //     isValid =false;
        // }
        if(!mobileno || mobileno == null) {
            validationError += `<li>Mobile number field is mandatory field.</li>`;
            isValid =false;
        }
        if(!receiveddate || receiveddate == null) {
            validationError += `<li>Received date field is mandatory field.</li>`;
            isValid =false;
        }
        if(!isValid) {
            toastr.error(validationError);
            bootbox.alert(`${validationError}`);
        }
        return isValid;
    }

    $("#leadMasterSubmit").click(function() {
        const isValid = validateForm();
        if(isValid) {
            let leadMastersData = $('#leadMasters').val();
            let name = $('#name').val();
            let email = $('#email').val();
            let mobileno = $('#mobileno').val();
            let altmobileno = $('#altmobileno').val();
            let receiveddate = $('#receiveddate').val();
            let remark = $('#remark').val();
            let items = [];

            $.each(JSON.parse(leadMastersData), function (key, value) { 
                let itemValue = {};
                // let master = []
                // let masterValues = [];
                let masterOperations = [];

                // master.push(value.id);
                itemValue ["master"] = value.id;
                // $('#ruleMaster_' + value.id + ' :selected').each(function (i, sel) {
                //     masterValues.push($(sel).val());
                // });
                let $masterValue = $('#leadMaster_' + value.id + ' :selected').val();
                if ($masterValue != "-- Select Condition --") {
                    itemValue ["masterValue"] = $masterValue;
                } else {
                    itemValue ["masterValue"] = null;
                }
                // $('#ruleCondition_' + value.id + ' :selected').each(function (i, sel) {
                //     masterOperations.push($(sel).val());
                // });
                // itemValue ["masterOperations"] = masterOperations;

                items.push(itemValue);

            });
       
        
       

            console.log("---items--",items);
            //jsonObject.masters = item;
            //jsonObject.push(items)
            // console.log(JSON.stringify(items));
            
        
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/leads/store',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'name': name,
                    'email': email,
                    'mobileno': mobileno,
                    'altmobileno': altmobileno,
                    'receiveddate': receiveddate,
                    'remark': remark,
                    'leadMasterData':JSON.stringify(items)
                },
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    window.location.href = "/leads";
                },
                error: function (data) {
                    console.log(data);
                    window.location.href = "/leads";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        
        }
    });
</script>
@endpush
