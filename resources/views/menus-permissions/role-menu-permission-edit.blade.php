@extends('layout.app')
@section('title', 'Role Wise Menu Permissions Management')
@section('subtitle', 'List of menus & their permissions')
@section('content')
@if($roleDetail)
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a href="#">
                        <h4>Permission Status For Role <i class="text-danger bold">{{ $roleDetail['name'] }}</i></h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                    <input id="roleId" name="roleId" value="{{ $roleId }}" type="hidden">
                    <ul class="nav nav-tabs">
                        <li  class="active"><a href="#masterTab" data-toggle="tab">All Menus</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="masterTab">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover defaultDataTable">
                                        <thead>
                                        <tr class="info">
                                            <th>S. No.</th>
                                            <th>Menu ID</th>
                                            <th>Menu Title</th>
                                            <th>Menu Preference</th>
                                            <th>Parent Name</th>
                                            <th>Menu Url</th>
                                            <th>View</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>Update Permission</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($menuPermissions) 
                                            <input id="emploeeId" type="hidden" value="{{ $roleId }}" />   
                                            <div style="display:none">                                                
                                                <input id="allPermissions" type="text" value="{{ json_encode($menuPermissions) }}" />
                                            </div>
                                            @foreach ($menuPermissions as $menu)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $menu->id }}</td>
                                                    <td>
                                                        {{ $menu->title }}
                                                        @if($menu->view_permission === 0) 
                                                        <i class='fa fa-info-circle' title="Since view permission for this menu is inactive, so other permissions are disabled." aria-hidden='true'></i>
                                                        @endif
                                                        
                                                    </td>
                                                    <td>{{ $menu->preference }}</td>
                                                    <td>{{ $menu->parentname ? $menu->parentname: 'No Parent' }}</td>
                                                    <td>{{ $menu->url }}</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input id="view_{{ $menu->id }}" value="{{ $menu->view_permission }}" type="hidden">
                                                            <input id="view_menu_{{ $menu->id }}" {{$menu->view_permission === 1 ? 'checked':''}} type="checkbox" value="{{ $menu->view_permission }}" onchange="handleChange(this);" @checked( $menu->view_permission === 'true') />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label class="switch">
                                                            <input id="add_{{ $menu->id }}" value="{{ $menu->add_permission }}" type="hidden">
                                                            <input {{$menu->view_permission === 0 ? 'disabled':''}}  id="add_menu_{{ $menu->id }}" {{$menu->add_permission === 1 ? 'checked':''}} type="checkbox" value="{{ $menu->add_permission }}" onchange="handleChange(this);" @checked( $menu->add_permission == '1') />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input id="edit_{{ $menu->id }}" value="{{ $menu->edit_permission }}" type="hidden">
                                                            <input {{$menu->view_permission === 0 ? 'disabled':''}}  id="edit_menu_{{ $menu->id }}" {{$menu->edit_permission === 1 ? 'checked':''}} type="checkbox" value="{{ $menu->edit_permission }}" onchange="handleChange(this);" @checked( $menu->edit_permission === 'true') />
                                                            <span class="slider round"></span>
                                                            
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input id="delete_{{ $menu->id }}" value="{{ $menu->delete_permission }}" type="hidden">
                                                            <input {{$menu->view_permission === 0 ? 'disabled':''}}  id="delete_menu_{{ $menu->id }}" {{$menu->delete_permission === 1 ? 'checked':''}} type="checkbox" value="{{ $menu->delete_permission }}" onchange="handleChange(this);" @checked( $menu->delete_permission === 'true') />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    
                                                    <td>
                                                        <input  id="parent_menu_{{ $menu->id }}" type="hidden" value="{{$menu->parent_id}}" />   
                                                        @if ((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))                                                
                                                            <button onclick="return showMessage(1)"  class="btn btn-sm btn-warning disabled" type="button">Update Permission</button>
                                                        @else
                                                            <button data-menuid="{{$menu->id}}" data-empid="{{$roleId}}" class="btn btn-sm btn-warning update-menu-permission-for-role" type="submit">Update Permission</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <br>
                        <!-- <button id="employeeMenuPermissionbtn" class="btn btn-sm btn-success" type="submit">Submit</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a href="#">
                        <h4 class="text-danger bold">No Role Found <i class="text-danger bold"></i></h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                    No Role With This Id Found!!
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
@push('custom-scripts')
<script>
    $(".update-menu-permission-for-role").click(function(){
            const self = this;
            bootbox.confirm({
                message: "Do you really want to update permission for this menu item?.",
                callback: function (confirm) {
                    if(confirm) {
                        processSingleMenuRolePermissionUpdate(self);
                    }
                    else {
                        window.location.reload();
                    }
                }
            });

        });

        function processSingleMenuRolePermissionUpdate(self) {
            const datamenuid = $(self).attr("data-menuid");
            const dataempid = $(self).attr("data-empid");
            let roleId = $("#roleId").val();
            console.log("---datamenuid--",datamenuid,"===dataempid==",dataempid);
            const add_permission_val =  $('#add_menu_' + datamenuid).val();
            const edit_permission_val =  $('#edit_menu_' + datamenuid).val();
            const delete_permission_val =  $('#delete_menu_' + datamenuid).val();
            const view_permission_val =  $('#view_menu_' + datamenuid).val();
            const menu_parent_id =  $('#parent_menu_' + datamenuid).val();
            console.log("--menu_parent_id-",menu_parent_id);
            const permissionData = {
                'menu_id':datamenuid,
                'role_id':roleId,
                'add_permissions':(add_permission_val == 1 || add_permission_val == "true" )?1:0,
                'edit_permissions':(edit_permission_val == 1 || edit_permission_val == "true" )?1:0,
                'delete_permissions':(delete_permission_val == 1 || delete_permission_val == "true" )?1:0,
                'view_permissions':(view_permission_val == 1 || view_permission_val == "true" )?1:0,
                'parent_id' : menu_parent_id
            }

            console.log(permissionData);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '/menus/role/set-single-permissions/'+roleId,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                data: {
                    _token: CSRF_TOKEN,
                    'roleId': roleId,
                    // 'rulesDate':JSON.stringify(items)
                    'permissionData':JSON.stringify(permissionData)
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (response) {
                    if(response?.message) {
                        bootbox.confirm({
                            message: "<p class='text-success ml-3 px-3 p-3 font-weight-bold'>"+response.message+"</p><p></p><p class='text-center font-weight-bold'><ul><li>Click 'OK' to redirect to role list page.</li><li> Click 'Cancel' to reload the page. </li></ul></p>",
                            callback: function (confirm) {
                                if(confirm) {
                                    // window.location.href = "/permissions/employee-list";
                                    window.location.href = "/permissions/role-list";
                                    // window.location.reload();
                                }
                                else {
                                    window.location.reload();
                                }
                            }
                        })
                    }
                },
                failure: function (data) {
                    console.log("failure response",data);
                    bootbox.alert("Request Failed!");
                },
                done: function (data) {
                    bootbox.alert("Request Completed!");
                },

                error: function (data) {
                    if(data?.responseText) {
                        const jsonResp = JSON.parse(data.responseText);
                        toastr.error(jsonResp.message);
                        bootbox.confirm(jsonResp.message, function(resp){
                            location.reload();
                        });
                    }

                }
            });
        }
</script>
@endpush