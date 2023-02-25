@extends('layout.app')
@section('title','Edit Employee')
@section('conent')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a>
                        <h4>Adminmaster Status</h4>
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
                        Add Employee</a>
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
                <h3><i class="fa fa-plus m-r-5"></i> Add EMPLOYEE </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form  method="post" class="form-horizontal" action="/createemployee">
                            @csrf
                            <fieldset>
                                <div class="col-md-12 form-group">
                                    <label>Admin Name <span class="required"> * </span></label>
                                    <select class="form-control" name="role_id" multiple>
                                      @foreach ($user as $users )
                                        <option value="{{$users->id}}">{{$users->name}}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">Employee Name </label>
                                    <input type="text" placeholder="Enter Employee Name" name="name" class="form-control">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label">Mobile Number </label>
                                    <input type="text" placeholder="Enter Mobile Number" name="contact" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">User Type</label>
                                    <select class="form-control" name="role_id"  disabled>
                                        @foreach ($role as $roles )
                                          <option value="{{$roles->id}}">{{$roles->name}}</option>
                                        @endforeach
                                      </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">Email Id </label>
                                    <input type="email" placeholder="Enter Email Id" name="email" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">Password</label>
                                    <input type="text" placeholder="Enter Password" name="password" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">DOB</label>
                                    <input type="date" placeholder="Enter DOB" name="dob" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">DOJ</label>
                                    <input type="date" placeholder="DOJ" name="doj" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">Alternate Mobile Number </label>
                                    <input type="text" placeholder="Alternate Mobile Number" name="alternate_contact" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">Designation Type</label>
                                   <select class="form-control" name="designation_id">
                                        @foreach ($designation as $designations )
                                          <option value="{{$designations->id}}">{{$designations->name}}</option>
                                        @endforeach
                                      </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">Profile Image </label>
                                    <input type="file" class="form-control" name="" disabled>
                                    <input type="hidden" class="form-control" value="user.png" name="profile_img">
                                </div>
                                <!--   <div class="col-md-6 form-group">
                                <label class="control-label">Max/Per Day</label>
                                <input type="text" placeholder="Enter Value" class="form-control">
                             </div>
                              <div class="col-md-6 form-group">
                                <label class="control-label">Max/Per Weekly</label>
                                <input type="text" placeholder="Enter Value" class="form-control">
                             </div> -->
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
