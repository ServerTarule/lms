@extends('layout.app')
@section('title', 'Master')
@section('content')
@if($mainmasters)
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                        <h4>{{ $master->name }} Management</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div>
                        <form action="/dynamic/{{ $master->id }}" method="post">
                            @csrf
                            <div class="row">
                                @if ( $mainmasters)
                                    @if($leadStatuses)
                                        @if( count($leadStatuses) != 0 )
                                            <div class="form-group col-sm-2">
                                                <label>Select Lead Status<span class="required"> * </span></label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <select class="form-control" name="leadStatusMasterId" id="leadStatusMasterId">
                                                    <option disabled>-- Select Lead Status --</option>
                                                        @foreach($leadStatuses as $leadStatus)
                                                            <option value="{{ $leadStatus->id }}">{{ $leadStatus->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endif
                                    @if($states)
                                        @if( count($states) != 0 )
                                            <div class="form-group col-sm-2">
                                                <label>Select State <span class="required"> * </span></label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <select class="form-control" name="stateMasterId" id="stateMasterId">
                                                    <option disabled>-- Select State --</option>
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}" {{$state->id  == $currentStateId ? 'selected' : ''}}>{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endif
                                <div class="form-group col-sm-2">
                                    <label>Name<span class="required"> * </span></label>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="text" name="name" placeholder="Main Master Value" class="form-control">
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    @if ( $mainmasters)
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="info">
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Create Date</th>
                                    <th>Modify</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($mainmasters as $mainmaster)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mainmaster->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mainmaster->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                   
                                    <a href="/master/main/edit-value/{{$master->id}}/{{$mainmaster->id}}" class="btn-xs">
                                        <button class="btn btn-xs btn-success btn-flat show_confirm" data-toggle="tooltip" title='Edit'>
                                            <i class="fa fa-edit" title='Edit'></i>
                                        </button>
                                        </a>
                                    </td>
                                    <td>
                                    @if($mainmaster->id != 8)
                                        <a href="#" id="deleteMainMaster" onclick="deleteMainMaster( {{ $mainmaster->id }} , {{ $master->id }})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    @endif
                                        <!-- <a href="/master/main/edit/{{ $mainmaster->id }}" class="btn-xs btn-info"> 
                                            <button class="btn btn-xs btn-success btn-flat show_confirm" data-toggle="tooltip" title='Edit'>
                                                <i class="fa fa-trash-o"></i> 
                                            </button>
                                        </a> -->
                                    @if($mainmaster->id == 8)
                                        <form method="POST" action="{{ route('mainmaster.delete', $mainmaster->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" onclick="return confirm('Are you sure want to delete this?')" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'><i
                                                    class="fa fa-trash"></i> </button>
                                        </form>
                                    @endif
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
                    @endif
                </div>
                @if (!$mainmasters  && $dynaicmaster)
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <form action="/master/main/update-value/{{ $master->id }}/{{$dynaicmaster->id}}" method="post">
                                    @csrf
                                    <div class="row">
                                    @if($dependentMasterData)
                                        @if( count($dependentMasterData) != 0 )
                                            <div class="col-md-2 form-group AUTHORITY">
                                                    <label>Select {{$dependentLabel}} *</label>
                                                </div>
                                                <div class="col-md-4 form-group AUTHORITY">
                                                    <select class="form-control" name="dependentId" id="stateMasterId">
                                                        <option disabled>-- Select Value --</option>
                                                            @foreach($dependentMasterData as $dependentMasterDt)
                                                                <option value="{{ $dependentMasterDt->id }}" {{$dependentMasterDt->id  == $currentDependentId ? 'selected' : ''}}>{{ $dependentMasterDt->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                        @endif
                                    @endif
                                        <div class="col-md-1 form-group AUTHORITY">
                                            <label>Name<span class="required"> * </span></label>
                                        </div>
                                        <div class="col-md-5 form-group AUTHORITY">
                                            <input type="text" name="name" placeholder="Main Master Value"  value="{{$dynaicmaster->name}}"  class="form-control" required>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group AUTHORITY">
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
@else
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a href="#">
                    <h4>No Master</h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                No Master With This ID found
            </div>
        </div>
    </div>
</div>
@endif                    
@endsection
