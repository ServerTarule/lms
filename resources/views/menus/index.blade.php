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
                                        <div class="col-md-12 form-group border AUTHORITY">
                                                <button type="submit" class=" btn btn-success " disabled="{{$userCrudPermissions['add_permission']}}">Create</button>
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
                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
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
                                                <a href="/menus/{{$menu->id}}" class="btn-xs">
                                                <button class="btn btn-xs btn-success btn-flat show_confirm" data-toggle="tooltip" title='Edit'>
                                                    <i class="fa fa-edit" title='Edit'></i>
                                                </button>
                                                </a>
                                            </td>
                                            <td>
                                            <form method="POST" action="{{ route('menus.delete', $menu->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" onclick="return confirm('Are you sure want to delete this?')" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'><i
                                                        class="fa fa-trash"></i> </button>
                                            </form>
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
@endsection
