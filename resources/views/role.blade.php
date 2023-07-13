@extends('layout.app')
@section('title', 'Manage Roles')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Roles Management</h4>
                        </a>
                    </div>
                </div>
                {{-- @php
                    dd($roles);
                @endphp --}}
                @if (!$roles)
                <div class="panel-body">
                    <div class="text-right">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form method="POST" action="/updaterole">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Role Name" value="{{$role->name}}" />
                                                    <input type="hidden" name="id" value="{{$role->id}}">
                                            </div>
                                            @if (session('status'))
                                                <span style="color:#00b100;">{{ session('status') }}</span>
                                            @endif
                                            @if (session('error'))
                                                <span style="color:#b10000;">{{ session('error') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-primary btn-submit bg-primary">Update
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>

                        </div>
                    </div>

                </div>
                @endif

                @if($roles)
                <div class="panel-body">
                    <div class="text-right">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <form method="POST" action="/createrole" onSubmit="return submitCreateRoleForm()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Role Name" />
                                            </div>
                                            @if (session('status'))
                                                <span style="color:#00b100;">{{ session('status') }}</span>
                                            @endif
                                            @if (session('error'))
                                                <span style="color:#b10000;">{{ session('error') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <button class="btn btn-sm btn-primary btn-submit bg-primary {{ (!$userCrudPermissions['add_permission']) ? ' disabled' : '' }}">Create
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a>S. No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Roles</a>
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
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if($userCrudPermissions['edit_permission'])
                                                <a href="/role/{{ $role->id }}" class="btn-xs btn-info"> <i
                                                    class="fa fa-edit"></i> </a>
                                            @else
                                                <a class="btn-xs btn-info {{(!$userCrudPermissions['edit_permission']) ? ' disabled' : '' }}"> <i
                                                    class="fa fa-edit {{(!$userCrudPermissions['edit_permission']) ? ' disabled' : '' }}"></i> </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($userCrudPermissions['delete_permission'])
                                            <a href="#" id="deleteRole" onclick="deleteRole( {{ $role->id }})" class="btn-xs btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @else
                                            <a  onclick="deleteRole( {{ $role->id }})" class="btn-xs btn-danger {{(!$userCrudPermissions['edit_permission']) ? ' disabled' : '' }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
<script>
    function submitCreateRoleForm() {
        const addPermission  = "{{$userCrudPermissions['add_permission']}}";
        if(!addPermission) {
            toastr.error("You are not allowed to add/create role!");
            return false;
        }
        else {
            return true;
        }
    }

    function deleteRole(id) {
        const deletePermission  = "{{$userCrudPermissions['delete_permission']}}";
        if(!deletePermission) {
            toastr.error("You are not allowed to delete role!");
            return false;
        }
        else if(deletePermission){
            bootbox.confirm(`Are you sure you want to delete this role?`, function (cofirm) {
                if(confirm) {
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        /* the route pointing to the post function */
                        url: '/role/destroy',
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
                            toastr.success( data.message);
                        },
                        error:function(xhr, status, error) {
                            console.log("error",xhr, xhr.responseText,status,error);
                            toastr.error( xhr.responseText);
                        },
                        failure: function (data) {
                            console.log(data);
                        }
                    });
                }
                else{
                    return false;
                }
                
            })       
        }
        
    }

</script>
@endpush
