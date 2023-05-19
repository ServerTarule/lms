@extends('layout.app')
@section('title', 'Master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>{{ $edit? 'Edit' : 'All'}} Master</h4>
                        </a>
                    </div>
                </div>
                @if ($masters)
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
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
                                        <div class="text-center">
                                            <input type="checkbox" name="main" id="checkbox">
                                            <label for="checkbox">Please tick the checkbox if its Main Master</label>
                                        </div>
                                    </form>
                                </div>
                                
                               
                            </div>
                            <div class="col-md-3">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"></div>
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
                                        <th>S. No.</th>
                                        <th>Masters Name</th>
                                        <th>Masters Type</th>
                                        <th>Create Date</th>
                                        <th>Modify &nbsp; <i class="fa fa-info-circle" title='Not allowed to edit main master'></i></th>
                                        <th>Delete &nbsp;  <i class="fa fa-info-circle" title='Not allowed to delete main master'></i></th>
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
                                                @if($master->master == 0)
                                                    <a href="/master/{{$master->id}}" class="btn-xs btn-info"> <i
                                                            class="fa fa-edit"></i> </a>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if($master->master == 0)
                                                <a href="#" id="deleteMaster" onclick="deleteMaster({{$master->id}})" class="btn-xs btn-danger">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                @else
                                                    -
                                                @endif
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
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-6">
                            <br />
                            <div class="text-right">
                                <form action="/master/{{$master->id}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-9 form-group AUTHORITY">
                                            <input type="text" name="name" value="{{ $master->name }}"
                                                placeholder="master Name" class="form-control" required {{$master->master ? 'readonly' : ''}}>
                                            <div>
                                                <button type="submit" class="btn btn-add">Update</button> 
                                            </div>
                                            
                                        </div>
                                        @if($master && $master->master)
                                        <div class="col-md-3 form-group AUTHORITY">
                                            <div style="text-align: center;margin-top:7px">
                                            <i style="font-size:30px; align:center" class="fa fa-10x fa-lg fa-info-circle" title='Not allowed to edit main master'></i>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div>
                            
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-6">
                        
                        @if (session('error'))
                            <span class="text-danger">{{ session('error') }}</span>
                        @endif
                        @if (session('status'))
                            <span class="text-success">{{ session('status') }}</span>
                        @endif
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                @endif
            </div>
        </div>
    </div>
@endsection
