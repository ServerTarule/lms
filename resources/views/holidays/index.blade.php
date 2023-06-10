@extends('layout.app')
@section('title', 'Holidays')
@section('subtitle', 'List of Holidays')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd ">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Holidays</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addHoliday"><i class="fa fa-plus"></i> Add Holiday</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="info">
                                <th>S. No.</th>
                                <th>Holiday Name</th>
                                <th>Date</th>
                                <th>Created Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($holidays as $holiday)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $holiday->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($holiday->day)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($holiday->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <!-- <a data-toggle="modal" data-target="#edititem" onclick="editHoliday({{$holiday->id}})" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a> -->
                                        <a onclick="return editHoliday({{ $holiday->id }})" class="btn-xs btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" id="deleteHoliday" onclick="deleteHoliday({{$holiday->id}})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addHoliday" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Add Holiday</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{ route('holidays.store') }}" method="POST" onsubmit="return validateForm()">
                                @csrf
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-8 form-group">
                                        <label class="control-label">Holiday Name</label>
                                        <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Date</label>
                                        <input type="date" id="day" name="day" placeholder="dd/mm/yyyy" class="form-control">
                                    </div>
                                    <div class="col-md-12 text-right form-group">
                                        <button type="button" class="btn btn-danger btn-sm" onSubmit="addItem()" data-dismiss="modal">Cancel</button>
                                        <button class="btn btn-add btn-sm">Save</button>
                                    </div>
                                </fieldset>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editHolidayPupup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-pencil m-r-5"></i> Edit Holiday</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal"  method="POST" >
                                @csrf
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-8 form-group">
                                        <label class="control-label">Holiday Name</label>
                                        <input type="text" id="name-edit" name="name" placeholder="Enter Name" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Date</label>
                                        <input type="date" id="day-edit" name="day" placeholder="dd/mm/yyyy" class="form-control">
                                    </div>
                                    
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <input type="hidden" name="holidayId" id="holidayId" value="">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-add btn-sm" id="updateItemButton" >Save</button>
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
   function validateForm(edit=false) {
        const name = (edit)?$("#name-edit").val().trim():$("#name").val().trim();
        const day = (edit)?$("#day-edit").val().trim():$("#day").val().trim();
        if(!name) {
            toastr.error("Holicay name field is required!");
            return false;
        }
        else if(!day) {
            toastr.error("Date field is required!");
            return false;
        }
        else {
            return true;
        }
        alert("Inside  validation");
    
    }
    function editHoliday(holidayId) {
        getHolidayData(holidayId);
    }

    function getHolidayData(holidayId) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#holidayId").val(holidayId);
        $.ajax({
            /* the route pointing to the post function */
            url: '/holidays/edit',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
            data: {
                _token: CSRF_TOKEN,
                'holidayId': holidayId
            },
            // data: $(this).serialize(),
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                const holiday = data.holiday;
                $("#name-edit").val(holiday?.name);
                $("#day-edit").val(holiday?.day);
                $('#editHolidayPupup').modal({
                    show: 'true'
                }); 
            },
            failure: function (data) {
                toastr.error("Error occurred while processin!!");
            }
        });
    }
    $("#updateItemButton").click(function(){
        updateHoliday()
    });

    function updateHoliday() {
        validateForm(1);
        const holidayId = $("#holidayId").val();
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function  /doctors/update/{id}*/
            url: `/holidays/update/${holidayId} `,
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'name':$("#name-edit").val(),
                'day':$("#day-edit").val()
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

   
</script>
@endpush