@extends('layout.app')
@section('title', 'Menus')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>All Menus</h4>
                        </a>
                    </div>
                </div>
                @if ($menus)
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="text-right">
                                    <form action="/menus" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="text" name="title" placeholder="Menu Title"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <select name="parent_id"  class="form-control" required>
                                                    <option value="0">No Parent</option>
                                                    @foreach ($menus as $menu)
                                                    <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="number" value="{{$menuWithTopPref->preference+1}}" name="preference" placeholder="Menu Preference" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="text" name="url" placeholder="Menu Url"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                            <input type="text" name="class" placeholder=" Css Class"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                            <input type="text" name="icon" placeholder="Css Icon"
                                                    class="form-control">
                                            </div>

                                        </div>
                                        <div class="row float-end">

                                        <!-- <div class="container-md">100% wide until medium breakpoint</div> -->
                                        <div class="col-md-12 form-group border AUTHORITY">
                                                <button type="submit" class=" btn btn-success"
                                                {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }}
                                                >Create permision</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                @if (session('error'))
                                    <span class="text-danger">{{ session('error') }}</span>
                                @endif
                                @if (session('status'))
                                    <span class="text-success">{{ session('status') }}</span>
                                @endif

                            </div>

                        </div>
                        <div class="table-responsive">
                            <table id="dataTable" class="defaultDataTable   table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>Menu Id.</th>
                                        <th>Menu Title</th>
                                        <th>Menu Url</th>
                                        <th>Menu Icon</th>
                                        <th>parent ID</th>
                                        <th>Parent Name</th>
                                        <th>Menu Preference</th>
                                        <th>Create Date</th>
                                        <th>Modify</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{ $menu->id }}</td>
                                            <td>{{ $menu->title }}</td>
                                            <td>{{ $menu->url }}</td>
                                            <td>{{ $menu->icon }} &nbsp;&nbsp;&nbsp;<i class="{!! $menu->icon !!}"></i></td>
                                            <td>{{ $menu->parent_id }}</td>
                                            <td>
                                                @if($menu->parent_name)
                                                {{ $menu->parent_name}}
                                                @else
                                                No Parent
                                                @endif
                                            </td>
                                            <td>{{ $menu->preference }}</td>
                                            <td>{{ \Carbon\Carbon::parse($menu->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                {{-- edit permission {{$userCrudPermissions['edit_permission']}} --}}
                                                @if((isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1))
                                                    <a onclick="showMessage(1)" class="btn btn-xs btn-success btn-flat show_confirm" data-toggle="tooltip" title='Edit' disabled>
                                                            <i class="fa fa-edit" title='Edit'></i>
                                                    </a>
                                                @else
                                                <a href="/menus/{{$menu->id}}" class="btn-xs">
                                                <button class="btn btn-xs btn-success btn-flat show_confirm" data-toggle="tooltip" title='Edit' >
                                                    <i class="fa fa-edit" title='Edit'></i>
                                                </button>
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                
                                            {{-- <form method="POST" onSubmit="return deleteMenu()"    action="{{ route('menus.delete', $menu->id) }}"> --}}
                                                {{-- @csrf --}}
                                                {{-- {{ (isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1) ? ' disabled' : '' }} --}}
                                                <input name="_method" type="hidden" id="menu_{{ $menu->preference }}" value="DELETE">
                                                {{-- {{ (isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1) ? ' disabled' : '' }} --}}
                                                @if((isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1))
                                                <a  onclick="showMessage(2)" class="btn btn-xs btn-danger btn-flat show_confirm " data-toggle="tooltip" title='Delete' disabled><i
                                                    class="fa fa-trash"></i> </a>
                                                @else
                                                <button type="submit"  onclick="deleteMenu( {{ $menu->id }})" class="btn btn-xs btn-danger btn-flat show_confirm " data-toggle="tooltip" title='Delete'  {{ (isset($userCrudPermissions['delete_permission'] ) &&  $userCrudPermissions['delete_permission'] != 1) ? ' disabled' : '' }}><i
                                                        class="fa fa-trash"></i> </button>
                                                @endif
                                            {{-- </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if (!$menus && $parentMenus)
                <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <form action="/menus/{{$menu->id}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="text" name="title" placeholder="Menu Title"
                                                    class="form-control" value="{{ $menu->title }}" required>
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <select name="parent_id"  class="form-control" required>
                                                    <option value="0">No Parent</option>
                                                    @foreach ($parentMenus as $parentMenu)
                                                    <option value="{{ $parentMenu->id }}" {{$menu->parent_id  == $parentMenu->id ? 'selected' : ''}}>{{ $parentMenu->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="number" value="{{ $menu->preference }}" name="preference" placeholder="Menu Preference" class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="text" name="url" placeholder="Menu Url"
                                                    class="form-control" value="{{ $menu->url }}" required>
                                            </div>

                                            <div class="col-md-4 form-group AUTHORITY">
                                            <input type="text" name="class" placeholder="Css Class"
                                                    class="form-control" value="{{ $menu->class }}">
                                            </div>
                                            <div class="col-md-4 form-group AUTHORITY">
                                                <input type="text" name="icon" placeholder="Css Icon"
                                                    class="form-control" value="{{ $menu->icon }}">
                                           </div>
                                        </div>
                                        <div class="row float-end ">
                                            <div class="col-md-12 form-group float-end border AUTHORITY">
                                                    <button type="submit" class="btn btn-warning ">update</button>

                                            </div>
                                        </div>

                                    </form>
                                </div>
                                @if (session('error'))
                                    <span class="text-danger">{{ session('error') }}</span>
                                @endif
                                @if (session('status'))
                                    <span class="text-success">{{ session('status') }}</span>
                                @endif

                            </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    {{-- bootbox.confirm('Are you sure want to delete this?')s --}}
@endsection
@push('custom-scripts')
<script>

function deleteMenu(id) {
    bootbox.confirm({
        message: "Are you sure you want to delete this center?",
        callback: function (confirm) {
            if(confirm) {
                processDeleteMenu(id);
            }
            else {
                return;
            }
        }
    });
}
function deleteMenussss() {
    // alert("Oooooooooooooo");
    bootbox.confirm('Are you sure want to delete this?',confirm=>{
        // alert("confirm=="+confirm)
        if(confirm === true) {
            return  true;
        }
        // return  false;
    } );
    return  false;
}

function processDeleteMenu(id) {
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        /* the route pointing to the post function */
        url: `/menus/delete/${id}`,
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: {
            _token: CSRF_TOKEN,
            'id': id
        },
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function (data) {
            alert(data)
            if(data.status) {
                toastr.success(data.message);
                setTimeout(function(){ 
                    location.reload();
                }, 3000);
            }
            else {
                toastr.error(data.message);
            }
        },
        failure: function (data) {
            toastr.error("Error occurred while processing!!");
        },
        error:function(xhr, status, error) {
            const resText = JSON.parse(xhr.responseText);
            toastr.error( resText.message);
        },
    });
}

</script>
@endpush
