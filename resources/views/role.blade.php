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
                                <form method="POST" action="/createrole">
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
                                                <button class="btn btn-sm btn-primary btn-submit bg-primary">Create
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
                                            <a href="/role/{{ $role->id }}" class="btn-xs btn-info"> <i
                                                    class="fa fa-edit"></i> </a>
                                        </td>
                                        <td>
                                            <a href="#" id="deleteRole" onclick="deleteRole( {{ $role->id }})" class="btn-xs btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
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
