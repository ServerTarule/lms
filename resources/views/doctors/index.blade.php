@extends('layout.app')
@section('title', 'Doctors')
@section('subtitle', 'List of doctors')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Doctor Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i
                                class="fa fa-plus"></i> Add Doctor</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
                                <th scope="col">
                                    <a>Doctor</a>
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
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td>{{$doctor->id}}</td>
                                    <td>{{$doctor->name}}</td>
                                    <td>{{$doctor->created_at}}</td>
                                    <td>
                                        <a onclick="return editDoctor({{ $doctor->id }})" class="btn-xs btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" id="deleteDoctor" onclick="deleteDoctor( {{ $doctor->id }})" class="btn-xs btn-danger">
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
    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Add Doctor </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal"id="addItemForm" method="POST">
                            @csrf 
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Doctor Name</label>
                                        <input type="text" name="doctorName" id="doctorNameAdd" placeholder="Doctor " class="form-control">
                                    </div>
                                    
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button id="addDoctorButton" class="btn btn-add btn-sm" >Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editDoctorModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-pencil m-r-5"></i> Edit Doctor </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Doctor Name</label>
                                        <input type="text" placeholder="Doctor "  id="doctorNameEdit" name="doctorName" class="form-control">
                                    </div>
                                </fieldset>
                            </form>
                            <div class="col-md-12 text-right form-group">
                                <input type="hidden" name="doctorId" id="doctorId" value="">
                                <button id="updateItemButton" class="btn btn-add btn-sm">Update Doctor</button>
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    </div>
@endsection


@push('custom-scripts')
<script type="text/javascript">
function editDoctor(doctorId) {
    getDoctorData(doctorId);
}

$("#addDoctorButton").click(function(){
    processAdd()
});

function processAdd () {
    const isValid = validateForm();
    if(isValid) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            /* the route pointing to the post function */
            url: '/doctors/addDoctors',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                'doctorName':$("#doctorNameAdd").val(),
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
    
}
function getDoctorData(doctorId) {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#doctorId").val(doctorId);
    console.log("========going to fetch data=====");
    $.ajax({
        /* the route pointing to the post function */
        url: '/doctors/edit',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
        data: {
            _token: CSRF_TOKEN,
            'doctorId': doctorId
        },
        // data: $(this).serialize(),
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            console.log("----returned data----",data);
            const doctor = data.doctor;
            $("#doctorNameEdit").val(doctor?.name);
            $('#editDoctorModal').modal({
                show: 'true'
            }); 
        },
        failure: function (data) {
            toastr.error("Error occurred while processin!!");
        }
    });
}
function validateForm(isEdit=false) {
    const name = (isEdit)?$("#doctorNameEdit").val().trim():$("#doctorNameAdd").val().trim();
    if(!name) {
        toastr.error("Doctor name field is required!");
        return false;
    }
    else {
        return true;
    }

}

$("#updateItemButton").click(function(){
    validateForm(true);
    const doctorId = $("#doctorId").val();
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        /* the route pointing to the post function  /doctors/update/{id}*/
        url: `/doctors/update/${doctorId} `,
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: {
            _token: CSRF_TOKEN,
            'doctorName':$("#doctorNameEdit").val()
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

});

function deleteDoctor(id) {
    bootbox.confirm("Are you sure you want to delete this doctor?", function (confirm) {
        if(confirm){
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/doctors/destroy',
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
                    window.location.href = "/doctors";
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            location.reload()   ;
        }
    })
}
</script>
@endpush