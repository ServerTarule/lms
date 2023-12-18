@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                            <span class="text-danger"><i  style="" class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add role(s).  </i></span>
                            <a class="btn btn-exp btn-sm" onclick="return showMessage()" {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }}><i class="fa fa-plus"></i> Add
                                Condition</a>
                        @else
                            
                            <a class="btn btn-exp btn-sm" href="/rules/create" {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }}><i class="fa fa-plus"></i> Add
                                Condition</a>
                        @endif
                        
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover defaultDataTable">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
                                <th scope="col">
                                    <a>Date</a>
                                </th>
                                <th scope="col">
                                    <a>Title</a>
                                </th>
                                <th scope="col">
                                    <a>No. of Master</a>
                                </th>
                                {{-- <th scope="col">
                                    <a>Apply On Destination</a>
                                </th> --}}
                                <th scope="col">
                                    <a>Edit</a>
                                </th>
                                <th scope="col">
                                    <a>Delete</a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rules as $rule)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rule->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $rule->name }}</td>
                                    <td>{{count($rule->ruleconditions)}}</td>
                                    {{-- <td></td> --}}
                                    <td>
                                        {{-- <a href="/rules/{{$rule->id}}" class="btn-xs btn-info">
                                            <i class="fa fa-edit"></i> </a> --}}
                                        <a onclick="return editRule({{ $rule->id }})" role="button" class="btn btn-xs btn-success btn-flat show_confirm" {{ (isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1) ? ' disabled' : '' }}>
                                            <i class="fa fa-edit" title='Edit'></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" id="deleteRule" onclick="deleteRule({{$rule->id}})" class="btn btn-xs btn-danger btn-flat show_confirm" {{ (isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1) ? ' disabled' : '' }}>
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
@endsection
@push('custom-scripts')

<script type="text/javascript">
    function editRule(ruleId) {
        const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
        if(!editPermission) {
            toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
            return false;
        }
        else {
           window.location.href =`/rules/${ruleId}`;
        }
    }
    function deleteRule(id) {
        const allowed  = "{{$userCrudPermissions['delete_permission']}}";
        if(!allowed) {
            toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
            return false;
        }
        else {
            processDelete(id);
        }
    }
    function processDelete(id) {
        bootbox.confirm("Are you sure you want to delete this rule?",confirm=>{
            if(confirm){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/conditions/destroy',
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
                        window.location.href = "/rules";
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
</script>
@endpush