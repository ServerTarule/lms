
@extends('layout.app')
@section('title', 'Manage Centers')


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Centres Status</h4>
                        </a>
                    </div>
                </div>
                @if (session('status'))
                <span style="color:#00b100;">{{ session('status') }}</span>
            @endif
            @if (session('error'))
                <span style="color:#b10000;">{{ session('error') }}</span>
            @endif
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i class="fa fa-plus"></i>
                            Add Centers</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> Center Id</a>
                                    </th>
                                    <th scope="col">
                                        <a>Center Details</a>
                                    </th>
                                    <th scope="col">
                                        <a>Mobile Number</a>
                                    </th>
                                    <th scope="col">
                                        <a>ALternate Mobile Number</a>
                                    </th>
                                    <th scope="col">
                                        <a>State</a>
                                    </th>
                                    <th scope="col">
                                        <a>City</a>
                                    </th>
                                    <th scope="col">
                                        <a>Owner Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Email Id</a>
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
                                    {{-- <th scope="col">
                                        <a>Block/Unblock</a>
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($centers as $center)
                                    <tr>
                                        <td>{{ $center->id }}</td>
                                        <td>{{$center->centerDetails }}</td>
                                        <td>{{ $center->mobile }}</td>
                                        <td>{{ $center->alternateMobile }}</td>
                                        <td>
                                            {{$center->state_name?$center->state_name:"N/A"}}
                                        </td>
                                        <td>
                                            {{$center->city_name?$center->city_name:"N/A"}}
                                        </td>
                                        <td>{{$center->ownerName}}</td>
                                        <td>{{$center->EmailId}}</td>
                                        <td>{{$center->created_at}}</td>


                                        <td>
                                            <a onclick="return editCenter({{ $center->id }})" class="btn-xs btn-info"> <i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a href="#" id="deleteCenter" onclick="deleteCenter( {{ $center->id }})" class="btn-xs btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                        {{-- <td>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
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
                    <h3><i class="fa fa-plus m-r-5"></i> Add Center </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form  id="addItemForm" class="form-horizontal">
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Doctor Name <span class="required text-danger"> * </span></label>
                                        <select class="form-control" id="role_id_select" name="role_id[]" rquired multiple>
                                          @foreach ($doctor as $doctors )
                                            <option value="{{$doctors->id}}">{{$doctors->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Center Details  <span class="required text-danger"> * </span></label>
                                        <input type="text" id="centerDetails" placeholder="Enter Center Details" name="centerDetails" class="form-control" rquired >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Mobile Number  <span class="required text-danger"> * </span></label>
                                        <input type="text" id="mobile" placeholder="Enter Mobile Number" name="mobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Alternate Mobile Number </label>
                                        <input type="text"  id="alternateMobile"  placeholder="Enter Alternate Number" name="alternateMobile" class="form-control" rquired >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">State  <span class="required text-danger"> * </span></label>
                                       <select class="form-control state-dropdown" name="state" id="state-dropdown" rquired >
                                            <option value="0">Select State </option>
                                            @foreach ($state as $states )
                                              <option value="{{$states->id}}">{{$states->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">City  <span class="required text-danger"> * </span></label>
                                       <select class="form-control city-dropdown" id="city-dropdown" name="city" rquired >
                                            <option value="0">Select City</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Owner Name </label>
                                        <input type="text" placeholder="Enter Owner Name" id="ownerName" name="ownerName" class="form-control" rquired >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Email Id </label>
                                        <input type="text"   id="emailId"  placeholder="Enter Email Id" name="EmailId" class="form-control" rquired >
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <button id="addItemButton" class="btn btn-add btn-sm">Add Center</button>
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Edit Center </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form  method="post" class="form-horizontal">
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Doctor Name <span class="required"> * </span></label>
                                        <select class="form-control" name="role_id[]" id="role_id_edit" multiple rquired>
                                          @foreach ($doctor as $doctors )
                                            <option value="{{$doctors->id}}">{{$doctors->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Center Details </label>
                                        <input type="text" placeholder="Enter Center Details" id="center_details_edit" name="centerDetails" class="form-control" rquired >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Mobile Number </label>
                                        <input type="text" placeholder="Enter Mobile Number" id="mobile_edit" name="mobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Alternate Mobile Number </label>
                                        <input type="text" placeholder="Enter Alternate Number" id="alternate_mobile_edit" name="alternateMobile" class="form-control" rquired >
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">State</label>
                                       <select class="form-control state-dropdown" name="state" id="state_dropdown_edit" rquired>
                                            <option value="0">Select State</option>
                                            @foreach ($state as $states )
                                              <option value="{{$states->id}}">{{$states->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">City</label>
                                       <select class="form-control city-dropdown" id="city_dropdown_edit" name="city" rquired>
                                            <option value="0">Select City</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Owner Name </label>
                                        <input type="text" placeholder="Enter Owner Name" id="owner_name_edit" name="ownerName" class="form-control" rquired>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Email Id </label>
                                        <input type="text" placeholder="Enter Email Id" id="email_id_edit" name="EmailId" class="form-control" rquired>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <input type="hidden" id="centerId" value="" name="centerId">
                                <button id="updateItemutton" class="btn btn-add btn-sm">Update Center</button>
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('custom-scripts')
<script type="text/javascript">
    $(".state-dropdown").change(function(){
        const stateId = $(this).val();
        getCityForState(stateId);
    });

    function getCityForState(stateId, cityId=0) {
        const firstOption = `<option value="0">Select City</option> `;
        $(".city-dropdown").html(`${firstOption}`);
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
                            $(".city-dropdown").append(`${option}`);
                        })
                    }
                    if(cityId > 0) {
                        $(".city-dropdown").val(cityId);
                    }
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching city data!');
                }
            });
        }
    }

    

    $("#addItemButton").click(function(){
        const isValid = validateForm(false);
        if(isValid) {
            checkDoctorOccupency();
        }
    });

    $("#updateItemutton").click(function(){
        const isValid = validateForm(true);
        if(isValid) {
            checkDoctorOccupency(true);
        }
        
    });

    function processAdd () {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function */
            url: '/centers/addCenter',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'roleId':$("#role_id_select").val(),
                'centerDetails':$("#centerDetails").val(),
                'mobile':$("#mobile").val(),
                'alternateMobile':$("#alternateMobile").val(),
                'state':$("#state-dropdown").val(),
                'city':$("#city-dropdown").val(),
                'city':$("#city-dropdown").val(),
                'ownerName':$("#ownerName").val(),
                'EmailId':$("#emailId").val()
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if(data.error) {
                    toastr.error(data.message);
                }
                else {
                    toastr.success(data.message);
                    $("#addItemForm")[0].reset()
                    $('#additem').modal('toggle');
                    setTimeout(function(){ 
                        location.reload();
                    }, 3000);
                }
               
            },
            failure: function (data) {
                toastr.error("Error occurred while processing!!");
            }
        });
    }

    function processUpdate () {
        validateForm(true);
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const centerId = $("#centerId").val();
        $.ajax({
            /* the route pointing to the post function */
            url: `/centers/updateCenter/${centerId} `,
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'roleId':$("#role_id_edit").val(),
                'centerDetails':$("#center_details_edit").val(),
                'mobile':$("#mobile_edit").val(),
                'alternateMobile':$("#alternate_mobile_edit").val(),
                'state':$("#state_dropdown_edit").val(),
                'city':$("#city_dropdown_edit").val(),
                'ownerName':$("#owner_name_edit").val(),
                'EmailId':$("#email_id_edit").val()
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if(data.error) {
                    toastr.error(data.message);
                }
                else {
                    toastr.success(data.message);
                    setTimeout(function(){ 
                        location.reload();
                    }, 3000);
                }

               
            },
            failure: function (data) {
                toastr.error("Error occurred while processing!!");
            }
        });

    }
    function editCenter(id) {
        $('#editItem').modal({
            show: 'true'
        }); 
        getDataForEdit(id);
    }

    function processDeleteCenter(id) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function */
            url: '/centers/destroy',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            data: {
                _token: CSRF_TOKEN,
                'id': id
            },
            // data: $(this).serialize(),
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                console.log(data);
                window.location.href = "/centers";
            },
            failure: function (data) {
                toastr.error("Error occurred while processin!!");
            }
        });
    }

    function getDataForEdit(id) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#centerId").val(id);
        $.ajax({
            /* the route pointing to the post function */
            url: '/centers/edit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            data: {
                _token: CSRF_TOKEN,
                'centerId': id
            },
            // data: $(this).serialize(),
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                console.log("----returned data----",data);
                const center = data.center;
                const doctorIds = data.doctors;
                $("#role_id_edit").val(doctorIds);
                $("#center_details_edit").val(center.centerDetails);
                $("#mobile_edit").val(center.mobile);
                $("#alternate_mobile_edit").val(center.alternateMobile);
                $("#state_dropdown_edit").val(center.state);
                getCityForState(center.state, center.city)
                $("#owner_name_edit").val(center.ownerName);
                $("#email_id_edit").val(center.EmailId);
            },
            failure: function (data) {
                toastr.error("Error occurred while processin!!");
            }
        });
    }

    function deleteCenter(id) {
        bootbox.confirm({
            message: "Are you sure you want to delete this center?.",
            callback: function (confirm) {
                if(confirm) {
                    processDeleteCenter(id);
                }
                else {
                    return;
                }
            }
        });
    }

    function checkDoctorOccupency(isEdit=false){
        const doctorIds = (isEdit)?$("#role_id_edit").val():$("#role_id_select").val();
        if(doctorIds == null || doctorIds?.length < 1) {
            bootbox.alert("Please select doctor Id(s).");
            return false
        }
        const centerId = $("#centerId").val();
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function */
            url: `/centers/checkdoctors/${isEdit}`,
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'doctorIds': doctorIds,
                'centerId':centerId
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                const doctorsDetail = data?.doctorsDetail;
                let message = "";
                if(doctorsDetail?.length) {
                    message += "<ul>";
                    $.each( doctorsDetail, function( index, doctorDetail ){
                        message += `<li>Dr. <b>${doctorDetail.name} </b> is already occupied at center with detail <b>'${doctorDetail.centerDetails}'</b> </li>\n`;
                        console.log( "Index #" + index + ": " + doctorDetail );
                    });
                    const process = (isEdit)? "Updating":"Adding";
                    message += `<br><b>Note: </b>${process} this center will assign this center to the selected doctor(s). Would you like to continue?`;
                    bootbox.confirm(message, function (confirm) {
                        if(confirm && !isEdit) {
                            processAdd();
                        }
                        else  if(confirm && isEdit) {
                            processUpdate();
                        }
                    });
                }
                else {
                    if(isEdit) {
                        processUpdate();
                    }
                    else {
                        processAdd();
                    }
                }
            },
            failure: function (data) {
                toastr.error("Error occurred while processing!!");
            }
        });

    }
    

    function validateForm(isEdit=false) {

        let isValid = true;
        let validationMessage = "<b>Please follow below instruction before submitting form.</b><ul>";
        const doctorIds = (isEdit)?$("#role_id_edit").val():$("#role_id_select").val();
        const centerDetails = (isEdit)?$("#center_details_edit").val():$("#centerDetails").val();
        const mobile = (isEdit)?$("#mobile_edit").val():$("#mobile").val();
        const alternateMobile = (isEdit)?$("#alternate_mobile_edit").val():$("#alternateMobile").val();
        const state = (isEdit)?$("#state_dropdown_edit").val():$("#state-dropdown").val();
        const city = (isEdit)?$("#city_dropdown_edit").val():$("#city-dropdown").val();
        const ownerName = (isEdit)?$("#owner_name_edit").val():$("#ownerName").val();
        const emailId = (isEdit)?$("#email_id_edit").val():$("#emailId").val();
        if(doctorIds == null || doctorIds?.length < 1) {
            validationMessage += `<li>Please select a doctor for the center. </li>`; 
            isValid=false;
        }
        if(centerDetails == null || centerDetails =="") {
            isValid=false;
            validationMessage += `<li>Please fill center details. </li>`; 
            
        }
        
        if(mobile == null || mobile =="") {
            validationMessage += `<li>Please fill mobile number. </li>`; 
            isValid=false;
        }

        // if(alternateMobile == null || alternateMobile =="") {
        //     validationMessage += `<li>Please fill alternate mobile number. </li>`; 
        //     isValid=false;
        // }
        if(state ==0 || state == null) {
            validationMessage += `<li>Please select state. </li>`; 
            isValid=false;
        }
        if(city ==0 || city == null) {
            validationMessage += `<li>Please select city. </li>`; 
            isValid=false;
        }
        // if(ownerName =="" || city == null) {
        //     validationMessage += `<li>Please fill owner name. </li>`; 
        //     isValid=false;
        // }
        // if(emailId =="" || emailId == null) {
        //     validationMessage += `<li>Please fill email Id. </li>`; 
        //     isValid=false;
        // }

        if(!isValid) {
            bootbox.alert(validationMessage);
        }
        return isValid;

    }

</script>
@endpush
