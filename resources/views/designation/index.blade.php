@extends('layout.app')
@section('title', 'Designation')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Designation status</h4>
                        </a>
                    </div>
                </div>
                @if ($designations)
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"></div>

                            <div class="col-md-4">
                                <div class="text-right">
                                    <form action="/designation" onSubmit="return addDesignation()" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 form-group AUTHORITY">
                                                <input type="text" name="name" placeholder="Designation Name"
                                                    class="form-control" required>
                                                <div>
                                                    <button type="submit" class="btn btn-add {{ (!$userCrudPermissions['add_permission']) ? ' disabled' : '' }}">Create</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if (session('error'))
                                    <span class="alert danger">{{ session('error') }}</span>
                                @endif
                                @if (session('status'))
                                    <span class="alert success">{{ session('status') }}</span>
                                @endif

                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>S. No.</th>
                                        <th>Designation Name</th>
                                        <th>Create Date</th>
                                        <th>Modify</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($designations as $designation)
                                        <tr>
                                            <td>{{ $designation->id }}</td>
                                            <td>{{ $designation->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($designation->created_at)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                            @if ($userCrudPermissions['edit_permission'])
                                                <a href="/designation/{{ $designation->id }}" class="btn-xs btn-info"> <i
                                                        class="fa fa-edit"></i> </a>
                                            @else
                                                <a  onclick="showMessage()" class="btn-xs btn-info disabled"><i class="fa fa-edit"></i> </a>
                                            @endif
                                            </td>
                                            <td>
                                                @if ($userCrudPermissions['edit_permission'])
                                                    <a onclick="return confirm('Are you sure want to delete this?')"
                                                        class="btn-xs btn-info" style="background: red;"> <i
                                                            class="fa fa-trash-o"></i>
                                                    </a>
                                                @else
                                                <a onclick="showMessage('delete')"
                                                        class="btn-xs btn-info disabled" style="background: red;"> <i
                                                            class="fa fa-trash-o disabled"></i>
                                                    </a>                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if (!$designations)
                    <div class="row">
                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <br />
                            <div class="text-right">
                                <form action="/designation/{{ $designation->id }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-group AUTHORITY">
                                            <input type="text" name="name" value="{{ $designation->name }}"
                                                placeholder="Designation Name" class="form-control" required>
                                            <div>
                                                <button type="submit" class="btn btn-add">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if (session('error'))
                                <span class="alert danger">{{ session('error') }}</span>
                            @endif
                            @if (session('status'))
                                <span class="alert success">{{ session('status') }}</span>
                            @endif

                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@push('custom-scripts')
<script>
function addDesignation() {
    const addPermission  = "{{$userCrudPermissions['add_permission']}}";
    if(!addPermission) {
        toastr.error("You are not allowed to add/create designation!");
        return false;
    }
    else {
        return true;
    }

    
}

function showMessage (action="edit/update") {
    toastr.error( `You are not allowed to ${action} designation!`);
}
</script>
@endpush