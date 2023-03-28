@extends('layout.app')
@section('title', 'Manage Centers')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Centres Status</h4>
                        </a>
                    </div>
                </div>
                @if (session('status'))
                <span style="color:#00b100;">{{ session('status') }}</span>
            @endif
            @if (session('error'))
                <span style="color:#b10000;">{{ session('error') }}</span>
            @endif
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#additem"><i class="fa fa-plus"></i>
                            Add Centers</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Center Details</a>
                                    </th>
                                    <th scope="col">
                                        <a>Mobile Number</a>
                                    </th>
                                    <th scope="col">
                                        <a>ALternate Mobile Number</a>
                                    </th>
                                    <th scope="col">
                                        <a>State</a>
                                    </th>
                                    <th scope="col">
                                        <a>City</a>
                                    </th>
                                    <th scope="col">
                                        <a>Owner Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Email Id</a>
                                    </th>
                                    <th scope="col">
                                        <a>Created Date</a>
                                    </th>
                                   
                                    <th scope="col">
                                        <a>Edit</a>
                                    </th>
                                    <th scope="col">
                                        <a>Delete</a>
                                    </th>
                                    {{-- <th scope="col">
                                        <a>Block/Unblock</a>
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templateMaster as $template)
                                    <tr>
                                        <td>{{ $template->id }}</td>
                                        <td>{{$template->centerDetails }}</td>
                                        <td>{{ $template->mobile }}</td>
                                        
                                        <td>
                                            {{-- <a data-toggle="modal" data-target="#edititem" class="btn-xs btn-info"> <i
                                                    class="fa fa-edit"></i> <span>Edit</span> </a> --}}
                                                    <a onclick="return confirm('Edit Action cannot perform now ! Site under Development')" class="btn-xs btn-info"> <i
                                                        class="fa fa-edit"></i> <span>Edit</span> </a>
                                        </td>
                                        <td>
                                            <a href=""onclick="if (confirm('are you sure you want to cancel?')) window.location.href='/cancel';                                            "
                                                class="btn-xs btn-info" style="background: #337ab7;">
                                                <span>Active</span>
                                            </a>
                                        </td>
                                        {{-- <td>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Add Center </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form  method="post" class="form-horizontal" action="/addCenter">
                                @csrf
                                <fieldset>
                                    <div class="col-md-12 form-group">
                                        <label>Doctor Name <span class="required"> * </span></label>
                                        <select class="form-control" name="role_id" multiple>
                                          @foreach ($doctor as $doctors )
                                            <option value="{{$doctors->id}}">{{$doctors->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Center Details </label>
                                        <input type="text" placeholder="Enter Center Details" name="centerDetails" class="form-control">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Mobile Number </label>
                                        <input type="text" placeholder="Enter Mobile Number" name="mobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Alternate Mobile Number </label>
                                        <input type="text" placeholder="Enter Alternate Number" name="alternateMobile" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">State</label>
                                       <select class="form-control" name="state">
                                            @foreach ($state as $states )
                                              <option value="{{$states->id}}">{{$states->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">City</label>
                                       <select class="form-control" name="city">
                                            @foreach ($city as $citys )
                                              <option value="{{$citys->id}}">{{$citys->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    
                                
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Owner Name </label>
                                        <input type="text" placeholder="Enter Owner Name" name="ownerName" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Email Id </label>
                                        <input type="text" placeholder="Enter Email Id" name="EmailId" class="form-control">
                                    </div>  
                                    
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-add btn-sm">Save</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
