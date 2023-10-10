@extends('layout.app')
@section('title', 'Master')
@section('content')
@if($mainmasters || $edit)
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
                    <input type="hidden" id="mainMasterId" value="{{ $master->id }}">
                    <div>
                        <form action="/dynamic/{{ $master->id }}" onsubmit="return saveMasterValues();" method="post">
                            @csrf
                            <div class="row">
                                @if ($mainmasters)
                                        @if(count($leadStatuses) > 0 || $master->id == '4')
                                            <div class="form-group col-sm-2">
                                                <label>Select Lead Status<span class="required text-danger"> * </span></label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <select class="form-control" name="leadStatusMasterId" id="leadStatusMasterIdAdd">
                                                    <option value="0">-- Select Lead Status --</option>
                                                        @foreach($leadStatuses as $leadStatus)
                                                            <option value="{{ $leadStatus->id }}">{{ $leadStatus->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        @if(count($states) > 0 || $master->id == '8')
                                            <div class="form-group col-sm-2">
                                                <label>Select State <span class="required text-danger"> * </span></label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <select class="form-control" name="stateMasterId" id="stateMasterIdAdd">
                                                    <option value="0">-- Select State --</option>
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}" {{$state->id  == $currentStateId ? 'selected' : ''}}>{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                <div class="form-group col-sm-2">
                                    <label>Name<span class="required text-danger"> * </span></label>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="text" name="name" placeholder="Main Master Value" id="masterValueFieldId" class="form-control">
                                    @if (session('error'))
                                    <span class="text-danger">{{ session('error') }}</span>
                                    @endif
                                    @if (session('status'))
                                        <span class="text-success">{{ session('status') }}</span>
                                    @endif
                                    @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                                    <span class="text-danger"><i  style="" class="fa fa-xs fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> Unauthorized to add "{{ $master->name }}".</i></span>
                                    @endif
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="submit" {{ (isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1) ? ' disabled' : '' }} class="btn btn-primary btn-sm" >Submit </button> 
                                        @if ((isset($userCrudPermissions['add_permission'] ) &&  $userCrudPermissions['add_permission'] != 1))
                                            <i role="button" style="" class=" btn  btn-warning btn-flat show_confirm fa fa-lg fa fa-exclamation-triangle" aria-hidden="true" title="You are not authorized to perform this action."> </i>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    @if ( $mainmasters)
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover defaultDataTable">
                            <thead>
                                <tr class="info">
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    @if($master->name =="Cities")
                                    <th>State Name</th>
                                    @elseif($master->name =='Lead Stages')
                                    <th>Lead Status Name</th>
                                    @endif
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
                                    @if($master->name =="Cities" || $master->name =='Lead Stages')
                                    <td>{{$mainmaster->parent_name}}</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($mainmaster->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <a onclick="return navigateToEditPage({{$master->id}}, {{$mainmaster->id}})" role="button" class="btn btn-xs btn-success btn-flat show_confirm"  {{ (isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1) ? ' disabled' : '' }}>
                                            <i class="fa fa-edit" title='Edit'></i>
                                        </a>
                                    </td>
                                    <td>
                                    @if($mainmaster->id != 8)
                                        <a href="#" id="deleteMainMaster" onclick="deleteMainMaster( {{ $mainmaster->id }} , {{ $master->id }})" class="btn btn-xs btn-danger btn-flat " {{ (isset($userCrudPermissions['edit_permission'] ) &&  $userCrudPermissions['edit_permission'] != 1) ? ' disabled' : '' }}>
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
                                <form action="/master/main/update-value/{{ $master->id }}/{{$dynaicmaster->id}}" onsubmit="return saveMasterValues(true);" method="post">
                                    @csrf
                                    <div class="row">
                                    @if($dependentMasterData)
                                        @if( count($dependentMasterData) != 0 )
                                            <div class="col-md-2 form-group AUTHORITY">
                                                    <label>Select {{$dependentLabel}} <span class="required text-danger"> * </span></label>
                                                </div>
                                                <div class="col-md-4 form-group AUTHORITY">
                                                    <select class="form-control" name="dependentId" id="parentMasterIdEdit">
                                                        <option value="0">-- Select Value --</option>
                                                            @foreach($dependentMasterData as $dependentMasterDt)
                                                                <option value="{{ $dependentMasterDt->id }}" {{$dependentMasterDt->id  == $currentDependentId ? 'selected' : ''}}>{{ $dependentMasterDt->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                        @endif
                                    @endif
                                        <div class="col-md-1 form-group AUTHORITY">
                                            <label>Name<span class="required text-danger"> * </span></label>
                                        </div>
                                        <div class="col-md-5 form-group AUTHORITY">
                                            <input type="text" name="name"  id="masterValueFieldId" placeholder="Main Master Value"  value="{{$dynaicmaster->name}}"  class="form-control">
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
@push('custom-scripts')
<script>
    
    function navigateToEditPage(id,mainMasterId) {
        const href = `/master/main/edit-value/${id}/${mainMasterId}`;
        const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
        if(!editPermission) {
            toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
            return false;
        }
        else {
            window.location.href = href;
        }
    }

    function saveMasterValues(isEdit=false) {
        alert("o asms"+"asdasd  == {{$userCrudPermissions['edit_permission']}}");
        if(isEdit) {
            const editPermission  = "{{$userCrudPermissions['edit_permission']}}";
            if(!editPermission) {
                toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
                return false;
            }
            else {
                return processSaveMasterValues(isEdit);
            }
        }
        else {
            const addPermission  = "{{$userCrudPermissions['add_permission']}}";
            if(!addPermission) {
                toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
                return false;
            }
            else {
                return processSaveMasterValues();
            }
        }
    }

    function processSaveMasterValues(isEdit=false) {
        let isValid =  true;
        const mainMasterId =  $("#mainMasterId").val();
        switch(mainMasterId) {
            case "1":
            case "2":
            case "3":
            case "5":
            case "6":
            case "7":
                isValid = validatForm("masterValueFieldId");
                // alert("--isValid--"+isValid)
                return isValid;
            break;
            
            case "4":
                let  leadStatusMasterId = isEdit?"parentMasterIdEdit":"leadStatusMasterIdAdd";
                isValid = validatForm("masterValueFieldId",leadStatusMasterId);
                return isValid;
            break;
            case "8":
                let  stateMasterId = isEdit?"parentMasterIdEdit":"stateMasterIdAdd";

                // alert("--stateMasterId--"+stateMasterId);
                
                
                isValid = validatForm("masterValueFieldId",stateMasterId);
                // return false;
                return isValid;
            break;
        
            default:
                // isValid = validatForm("masterValueFieldId");
                return isValid;
            break;
        }
        return isValid;
    }
    

    function validatForm(masterInputId = "masterValueFieldId", masterParentInputId=null ){
        // alert("o asdasdasasms");
        if(!masterParentInputId && !masterInputId){
            return false;
        }
        else {
            // alert("--masterParentInputId--"+masterParentInputId)
            masterParentInputValue = $("#"+masterParentInputId).val();
            // alert("-----masterParentInputValue---"+masterParentInputValue+"----"+typeof masterParentInputValue);
            masterInputValue = $("#"+masterInputId).val();
            // alert("-----masterInputValue---"+masterInputValue);
            // console.log("===masterInputValue===",masterInputValue);
            if(masterParentInputId && (!masterParentInputValue || masterParentInputValue =="" || masterParentInputValue =="0"))  {
                // alert("parent value is not there")
                toastr.error("Please select required value from dropdown!");
                return false;
            }
            else if(!masterInputValue || masterInputValue =="") {
                toastr.error("Please fill name!");
                return false;
            }
            else {
                // alert("----------------else--------------- !");
                return true;
            }
        }
    }
    
    function deleteMainMaster(id,masterid) {
        const deletePermission  = "{{$userCrudPermissions['delete_permission']}}";
        if(!deletePermission) {
            toastr.error(NOT_AUTHORIZED_TO_PERFORM_ACTION);
            return false;
        }
        else {
            processDeleteMainMaster(id,masterid);
        }
    }
    function processDeleteMainMaster(id, masterid) {
        bootbox.confirm("Are you sure you want to delete this?", confirm=>{
            if(confirm){
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    /* the route pointing to the post function */
                    url: `/master/main/destroy/${masterid}/${id}`,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    // data: {_token: CSRF_TOKEN, 'ruleData':JSON.stringify(jsonObject)},
                    data: {
                        _token: CSRF_TOKEN,
                        'id': id
                    },
                    // data: $(this).serialize(),
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/master/main/"+masterid;
                    },
                    failure: function (data) {
                        console.log(data);
                    },
                    error:function(xhr, status, error) {
                        const resText = JSON.parse(xhr.responseText);
                        toastr.error( resText.message);
                    },
                });
            }
        else{
            return false;
        }
    

    })
        
    }
</script>
@endpush                