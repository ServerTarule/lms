@extends('layout.app')
@section('title', 'Roles')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a href="#">
                        <h4>Role List to Manage Permissions</h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="table-responsive">
                    <table id="defaultDataTable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr class="tblheadclr1">
                                        <th scope="col">
                                            <a>S. No.</a>
                                        </th>
                                        <th scope="col">
                                            <a>Role ID</a>
                                        </th>
                                        <th scope="col">
                                            <a>Role Name</a>
                                        </th>
                                        <th scope="col">
                                            <a>Created Date</a>
                                        </th>
                                        <th scope="col">
                                            <a>Edit Permissions</a>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($roles)
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->id}}</td>
                                                <td>{{ $role->name}}</td>
                                                <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y') }}</td>
                                                <td class="align-items-center">
                                                    {{-- <a href="/role-permission/menu-list/{{$role->id}}" class="btn-xs btn-info"> <i
                                                            class="fa fa-edit"></i> </a> --}}
                                                    @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                                        <button  onclick="return showMessage(1)" class="btn btn-xs btn-success btn-flat show_confirm disabled"> <i
                                                            class="fa fa-edit"></i> </button>
                                                    @else
                                                        <a class="btn btn-xs btn-success btn-flat show_confirm" onclick="return manageRolePermissions({{ $role->id }})" > <i
                                                            class="fa fa-edit {{(!$userCrudPermissions['edit_permission']) ? ' disabled' : '' }}"></i> </a>
                                                    @endif
                                                </td>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection 
@push('custom-scripts')
<script>
    function manageRolePermissions(id) {
        const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
        if(!editPermission) {
            toastr.error("You are not allowed to add/create role!");
            return false;
        }
        else {
            ////role-permission/menu-list/{{$role->id}}
            window.location.href =  `/role-permission/menu-list/${id}`;
        }
    }
</script>
@endpush