@extends('layout.app')
@section('title', 'Employee Permissions Management')
@section('subtitle', 'List of menus & their permissions')
@section('content')
@if($employeeDetail)
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a href="#">
                        <h4>Permission Status For Employee <i class="text-danger bold">{{ $employeeDetail['name'] }}</i></h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                    <input id="employeeId" name="employeeId" value="{{ $employeeId }}" type="hidden">
                    <ul class="nav nav-tabs">
                        <li  class="active"><a href="#masterTab" data-toggle="tab">All Menus</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="masterTab">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr class="info">
                                            <th>S. No.</th>
                                            <th>Menu ID</th>
                                            <th>Menu Title</th>
                                            <th>Parent Name</th>
                                            <th>View</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>Update Permission</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($menuPermissions) 
                                            <input id="emploeeId" type="hidden" value="{{ $employeeId }}" />   
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
                                                    <td>{{ $menu->parentname ? $menu->parentname: 'No Parent' }}</td>
                                                    
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
                                                        <button data-menuid="{{$menu->id}}" data-empid="{{$employeeId}}" class="btn btn-sm btn-warning update-menu-permission" type="submit">Update Permission</button>
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
                        <h4 class="text-danger bold">No Employee Found <i class="text-danger bold"></i></h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                    No Employee With This Id Found!!
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
