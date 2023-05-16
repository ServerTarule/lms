@extends('layout.app')
@section('title', 'Master')
@section('content')
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
                                @if($leadStatuses)
                                    @if( count($leadStatuses) != 0 )
                                        <div class="form-group col-sm-2">
                                            <label>Select Lead Status<span class="required"> * </span></label>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <select class="form-control" name="leadStatusMasterId" id="leadStatusMasterId">
                                                <option disabled>-- Select Lead Status --</option>
{{--                                                @php--}}
{{--                                                    $values = $master->values()->get();--}}
{{--                                                @endphp--}}
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
                                            <label>Select State<span class="required"> * </span></label>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <select class="form-control" name="stateMasterId" id="stateMasterId">
                                                <option disabled>-- Select State --</option>
{{--                                                @php--}}
{{--                                                    $values = $master->values()->get();--}}
{{--                                                @endphp--}}
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
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
                            </div>
                        </form>
                    </div>
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
                            @foreach ($mainmasters as $mainmaster)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mainmaster->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mainmaster->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <a href="#" id="deleteMainMaster" onclick="deleteMainMaster( {{ $mainmaster->id }} , {{ $master->id }})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
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
