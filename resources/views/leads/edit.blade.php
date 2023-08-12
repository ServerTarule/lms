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
                                                name="receivedDate"
                                                placeholder="Enter Received Date"
                                                value="{{$lead->receiveddate ?? now()->setTimezone('T')->format('Y-m-dTh:m')}}"
                                                type="datetime-local"
                                            />
                                            <!-- {{ now()->setTimezone('T')->format('Y-m-dTh:m') }} -->
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
                                                    <label for="myupld" class="myupldicon"><i class="fa fa-cloud-upload"></i></label>
                                                    <input type="file" id="myupld" multiple="" />
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
                                                            @php
                                                                $valueToSelect = $leadMasterKeyValueArray[$master->id];
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
    // alert(selectedCenterId);
    if(state && state > 0) {
        getCityForState(state, city)
    }
   
    console.log("====isFirstCalling===="+isFirstCalling);
    const masterDependentObjName = {7:"Cities",3:'Lead Stages'};
    // const leadMasterKeyValueArray =  ' print_r($leadMasterKeyValueArray); ?>'
    const leadMasterKeyValueArray =  {{ Js::from($leadMasterKeyValueArray) }};
    console.log("---leadMasterKeyValueArray---",leadMasterKeyValueArray)
    // Object.entries(obj)
    for (const [parentMasterId, childMasterId] of Object.entries(masterDependentObj)) {
        console.log(`${parentMasterId} ${childMasterId}`); // "a 5", "b 7", "c 9"
        const parentElementId =  `leadMaster_${parentMasterId}`;
        const parentIdValue = $(`#${parentElementId}`).val();
        console.log("--childMasterId---",childMasterId);
        const masterName = masterDependentObjName[parentMasterId];
        //$leadMasterKeyValueArray[$master->id]
        
        const selectedValue = leadMasterKeyValueArray[childMasterId];
        console.log("==selectedValue==",selectedValue)
        getDataFromDb(parentIdValue, childMasterId, masterName, selectedValue)
    }

    // masterDependentObj.foreach(function(masterDependentEle,masterDependentKey) {
    //     console.log("--masterDependentEle---",masterDependentEle);
    //     console.log("--masterDependentKey---",masterDependentKey);

    // })
    function getDependentData (event,masterName){
        const selectElement = event.target;
        const parentId = selectElement.value;
        const masterId = $(selectElement).data('masterid');
        const dependentId = masterDependentObj[masterId];
        const dependentName = masterDependentObjName[masterId];
        
        if(parseInt(parentId) > 0) {
            getDataFromDb(parentId, dependentId, dependentName)
        }
    }

    function getDataFromDb(parentId, dependentId, masterName='Option', dependentValueToSelect = 0) {
        console.log("----parentId----",parentId);
        const dependentElementId =  `leadMaster_${dependentId}`;
        console.log("--dependentElementId-----",dependentElementId);
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const option = `<option value="0">-- Select  ${masterName}--</option>`;
        $(`#${dependentElementId}`).html(`${option}`);
        let selectedText = '';
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
                console.log("=====result====",result)
                let dependentValues = [];
                if(result?.dependentValues) {
                    dependentValues = result?.dependentValues??[];
                   
                    dependentValues.forEach(dependentValue=>{
                        if(dependentValueToSelect == `${dependentValue.id}`) {
                            //selectedText = 'selected';
                        }
                        const option = `<option value="${dependentValue.id}" ${selectedText}>${dependentValue.name} </option>`;
                        $(`#${dependentElementId}`).append(`${option}`);
                    });

                    $(`#${dependentElementId}`).val(`${dependentValueToSelect}`);
                }
            },
            failure: function (result) {
                toastr.error('Error occurred while fetching related data!');
            }
        });
    }

    function getCityForState(stateId, cityId=0) {
        console.log("====stateId==="+stateId);
        const firstOption = `<option value="0">Select City</option> `;
        // $("#leadMaster_8").html(`${firstOption}`);
        $("#city-dropdown").html(`${firstOption}`);
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
                            $("#city-dropdown").append(`${option}`);
                        })
                    }
                    if(cityId > 0) {
                        $("#city-dropdown").val(cityId);
                        getCenterForStateAndCity(selectedCenterId);
                    }
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching city data!');
                }
            });
        }
    }

    function getCenterForStateAndCity(centerId=0) {
        const stateId = $("#state-dropdown").val();
        const cityId = $("#city-dropdown").val();
        console.log("selectedCenterId ===",centerId,"--Called --getCenterForStateAndCity----values of state is -- ", stateId,'----value of city id is ---', cityId)
        const firstOption = `<option value="0">Select Center</option> `;
        // $("#leadMaster_8").html(`${firstOption}`);
        $("#center-detail").html(`${firstOption}`);
        if(parseInt(stateId) > 0  && parseInt(cityId) > 0 ) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/centers/getCenterByLocation',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'stateId': stateId,
                    'cityId': cityId
                },
                dataType: 'JSON',
                success: function (result) {
                    let centers = [];

                    if(result?.centers) {
                        centers = result?.centers??[];
                        centers.forEach(center=>{
                            const option = `<option value="${center.id}">${center.centerDetails}</option>`;
                            $("#center-detail").append(`${option}`);
                        })
                    }
                    if(centerId > 0) {
                        $("#center-detail").val(centerId);
                    }
                
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching centers data!');
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
        
        if(!mobileno || mobileno == null) {
            validationError += `<li>Mobile number field is mandatory field.</li>`;
            isValid =false;
        }
        else if(mobileno) {
            //don noting
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
    function processSaveLeadInformation() {
        const isValid = validateForm();
        // alert("I am valid or not"+isValid);

        // <form  method="post" id="updateLeadForm" class="form-horizontal" enctype="multipart/form-data" >
        // updateLeadForm
        var form_data = new FormData($('#updateLeadForm')[0]);
        console.log("---form_data inside processSaveLeadInformation-----",form_data);
        
        if(isValid) {
            let leadMastersData = $('#leadMasters').val();
            let name = $('#name').val();
            let email = $('#email').val();
            let mobileno = $('#mobileno').val();
            let altmobileno = $('#altmobileno').val();
            let receiveddate = $('#receiveddate').val();
            let centerId = $('#center-detail').val();
            console.log("===value of centerId =="+centerId);
            let remark = $('#remark').val();
            let items = {};
            // items[0] = 0;
            const leadId =  $("#leadId").val();
            console.log("----leadMastersData----",leadMastersData)
            $.each(JSON.parse(leadMastersData), function (key, value) { 
                let itemValue = {};
                let masterOperations = [];
                let $masterValue = $('#leadMaster_' + value.id + ' :selected').val();
                items['leadMaster_'+value.id] = $masterValue?$masterValue:0;
            });
            console.log("---items--",items);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const dataToPost = {
                    _token: CSRF_TOKEN,
                    'name': name,
                    'email': email,
                    'mobileno': mobileno,
                    'altmobileno': altmobileno,
                    'receiveddate': receiveddate,
                    'remark': remark,
                    'leadMasterData':items
                };
            if(isFirstCalling) {
                const stateId = $("#state-dropdown").val();
                const cityId = $("#city-dropdown").val();
                dataToPost["isFirstCalling"] = isFirstCalling;
                dataToPost["state"] = stateId;
                dataToPost["city"] = cityId;
                dataToPost["centerId"] = centerId;
            }
            $.ajax({
                /* the route pointing to the post function */
                url: `/leads/updatelead/${leadId}`,
                type: 'POST',
                contentType: false,
                processData: false,
                data: dataToPost,
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    // window.location.href = "/leads";
                },
                error: function (data) {
                    console.log(data);
                    // window.location.href = "/leads";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        
        }
    }
    $("#leadMasterSubmitUpdate").click(function() {
        // alert("_ I am oe")
        const isValid = validateForm();
        // processSaveLeadInformation(); return false;
        // alert("I am valid or not"+isValid);

        // <form  method="post" id="updateLeadForm" class="form-horizontal" enctype="multipart/form-data" >
        // updateLeadForm
        var form_data = new FormData($('#updateLeadForm')[0]);
        console.log("---form_data-----",form_data);
        
        if(isValid) {
            let leadMastersData = $('#leadMasters').val();
            let name = $('#name').val();
            let email = $('#email').val();
            let mobileno = $('#mobileno').val();
            let altmobileno = $('#altmobileno').val();
            let receiveddate = $('#receiveddate').val();
            let centerId = $('#center-detail').val();
            console.log("===value of centerId =="+centerId);
            let remark = $('#remark').val();
            let items = {};
            // items[0] = 0;
            const leadId =  $("#leadId").val();
            console.log("----leadMastersData----",leadMastersData)
            $.each(JSON.parse(leadMastersData), function (key, value) { 
                let itemValue = {};
                let masterOperations = [];
                let $masterValue = $('#leadMaster_' + value.id + ' :selected').val();
                items['leadMaster_'+value.id] = $masterValue?$masterValue:0;
            });
            console.log("---items--",items);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const dataToPost = {
                    _token: CSRF_TOKEN,
                    'name': name,
                    'email': email,
                    'mobileno': mobileno,
                    'altmobileno': altmobileno,
                    'receiveddate': receiveddate,
                    'remark': remark,
                    'leadMasterData':items
                };
            if(isFirstCalling) {
                const stateId = $("#state-dropdown").val();
                const cityId = $("#city-dropdown").val();
                dataToPost["isFirstCalling"] = isFirstCalling;
                dataToPost["state"] = stateId;
                dataToPost["city"] = cityId;
                dataToPost["centerId"] = centerId;
            }
            let redirectUrl = "/leads";
            if(isFirstCalling) {
                redirectUrl = "/leads/calls/"+leadId;
            }
            $.ajax({
                /* the route pointing to the post function */
                url: `/leads/updatelead/${leadId}`,
                type: 'POST',
                // contentType: false,
                // processData: false,
                data: dataToPost,
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    if(data.status) {
                        toastr.success(data.message);
                    }
                    else {
                        toastr.error(data.message);
                    }
                    setTimeout(function(){ 
                        window.location.href = redirectUrl;
                    }, 3000);
                },
                error: function (data) {
                    toastr.error(data.message);
                    setTimeout(function(){ 
                        window.location.href = redirectUrl;
                    }, 3000);
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        
        }
    });
</script>
@endpush
