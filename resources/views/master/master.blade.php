@extends('layout.app')
@section('title', 'Master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                        <h4>Main Master Management</h4>
                        </a>
                    </div>
                </div>
                @if ($mains)
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="info">
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>Create Date</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mains as $master)
                                        <tr>
                                            <td>{{ $master->id }}</td>
                                            <td>{{ $master->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($master->created_at)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <a href="/master/main/edit/{{ $master->id }}" class="btn-xs btn-info"> <i
                                                        class="fa fa-trash-o"></i> </a>
                                            </td>
                                            {{-- <td>
                                                <a onclick="return confirm('Are you sure want to delete this?')"
                                                    class="btn-xs btn-info" style="background: red;"> <i
                                                        class="fa fa-trash-o"></i>
                                                </a>
                                            </td> --}}
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                {{-- @if (!$mains)
                    <div class="row">
                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <br />
                            <div class="text-right">
                                <form action="/dynamic/edit/{{ $master->id }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-group AUTHORITY">
                                            <input type="text" name="name" value="{{ $master->name }}"
                                                placeholder="master Name" class="form-control" required>
                                                <input type="hidden" name="parent_id" value="{{$master->parent_id}}">
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
                @endif --}}
            </div>
        </div>
    </div>

@endsection
