@extends('layout.app')
@section('title', 'Master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>All Master</h4>
                        </a>
                    </div>
                </div>
                @if ($masters)
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="text-right">
                                    <form action="/master" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12 form-group AUTHORITY">

                                                <input type="text" name="name" placeholder="Master Name"
                                                    class="form-control" required>
                                                <div>
                                                    <button type="submit" class="btn btn-add">Create</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="main" id="checkbox">
                                            <label for="checkbox">Please tick the checkbox if its Main Master</label>
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
                                        <th>Masters Name</th>
                                        <th>Masters Type</th>
                                        <th>Create Date</th>
                                        <th>Modify</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masters as $master)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $master->name }}</td>
                                            <td>@if($master->master == 1)
                                                Main Master
                                            @else
                                                Dynamic Master
                                            @endif</td>
                                            <td>{{ \Carbon\Carbon::parse($master->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="/master/{{$master->id}}" class="btn-xs btn-info"> <i
                                                        class="fa fa-edit"></i> </a>
                                            </td>
                                            <td>
                                                <a href="#" id="deleteMaster" onclick="deleteMaster({{$master->id}})" class="btn-xs btn-danger">
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
                @if (!$masters)
                    <div class="row">
                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <br />
                            <div class="text-right">
                                <form action="/master/{{$master->id}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-group AUTHORITY">
                                            <input type="text" name="name" value="{{ $master->name }}"
                                                placeholder="master Name" class="form-control" required>
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
