
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
                                        <a> S.No.</a>
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
                                            {{-- <a data-toggle="modal" data-target="#edititem" class="btn-xs btn-info"> <i
                                                    class="fa fa-edit"></i> <span>Edit</span> </a> --}}
                                                    <a onclick="return editCenter({{ $center->id }})" class="btn-xs btn-info"> <i
                                                        class="fa fa-edit"></i></a>
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
                            <form  method="post" class="form-horizontal" action="/addCenter">
                                @csrf
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Doctor Name <span class="required"> * </span></label>
                                        <select class="form-control" name="role_id[]" multiple>
                                          @foreach ($doctor as $doctors )
                                            <option value="{{$doctors->id}}">{{$doctors->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Center Details </label>
                                        <input type="text" placeholder="Enter Center Details" name="centerDetails" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Mobile Number </label>
                                        <input type="text" placeholder="Enter Mobile Number" name="mobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Alternate Mobile Number </label>
                                        <input type="text" placeholder="Enter Alternate Number" name="alternateMobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">State</label>
                                       <select class="form-control state-dropdown" name="state" id="state-dropdown">
                                            <option value="0">Select State</option>
                                            @foreach ($state as $states )
                                              <option value="{{$states->id}}">{{$states->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">City</label>
                                       <select class="form-control city-dropdown" id="city-dropdown" name="city">
                                            <option value="0">Select City</option>
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Owner Name </label>
                                        <input type="text" placeholder="Enter Owner Name" name="ownerName" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Email Id </label>
                                        <input type="text" placeholder="Enter Email Id" name="EmailId" class="form-control">
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-dismiss="modal">Cancel</button>
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
                            <form  method="post" class="form-horizontal" action="/addCenter">
                                @csrf
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Doctor Name <span class="required"> * </span></label>
                                        <select class="form-control" name="role_id[]" id="role_id_edit" multiple>
                                          @foreach ($doctor as $doctors )
                                            <option value="{{$doctors->id}}">{{$doctors->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Center Details </label>
                                        <input type="text" placeholder="Enter Center Details" id="center_details_edit" name="centerDetails" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Mobile Number </label>
                                        <input type="text" placeholder="Enter Mobile Number" id="mobile_edit" name="mobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Alternate Mobile Number </label>
                                        <input type="text" placeholder="Enter Alternate Number" id="alternate_mobile_edit" name="alternateMobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">State</label>
                                       <select class="form-control state-dropdown" name="state" id="state-dropdown-edit">
                                            <option value="0">Select State</option>
                                            @foreach ($state as $states )
                                              <option value="{{$states->id}}">{{$states->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">City</label>
                                       <select class="form-control city-dropdown" id="city-dropdown-edit" name="city">
                                            <option value="0">Select City</option>
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Owner Name </label>
                                        <input type="text" placeholder="Enter Owner Name" name="ownerName" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Email Id </label>
                                        <input type="text" placeholder="Enter Email Id" name="EmailId" class="form-control">
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-dismiss="modal">Cancel</button>
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
@push('custom-scripts')
<script type="text/javascript">
    $(".state-dropdown").change(function(){
        const stateId = $(this).val();
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
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching city data!');
                }
            });
        }
    });

    function editCenter(id) {
        // bootbox.alert(id);
        // $("#editItem")
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
        console.log("centerId",id);
        toastr.warning(" This module is under development, It will be deployed soon!!");
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                console.log(data);
                // $("#role_id_edit").val(data?.center.)
                // window.location.href = "/centers";
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
</script>
@endpush
