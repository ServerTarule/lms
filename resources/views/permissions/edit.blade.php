@extends('layout.app')
@section('title', 'Employee Permissions Management')
@section('subtitle', 'List of Permissions')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Permission Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                        <input id="employeeId" name="employeeId" value="{{ $employeeId }}" type="hidden">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#rulesTab" data-toggle="tab">Rules</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="rulesTab">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                            <tr class="info">
                                                <th>S. No.</th>
                                                <th>Title</th>
                                                <th>Apply</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($rules)
                                                <input id="employeePermissionRules" type="hidden" value="{{ $rules }}" />
                                                @foreach ($rules as $rule)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $rule->name }}</td>
                                                        <td>
                                                            <label class="switch">
                                                                @php
                                                                    $ruleStatus = 'false';
                                                                    $employeeRule = App\Models\EmployeeRule::where(['employee_id' => $employeeId, 'rule_id' => $rule->id])->first();
                                                                    if (!is_null($employeeRule)) {
                                                                        $ruleStatus = $employeeRule->status;
                                                                    }
                                                                @endphp
                                                                <input id="test_{{ $rule->id }}" value="{{ $ruleStatus }}" type="hidden">
                                                                <input id="rule_{{ $rule->id }}" type="checkbox" value="true" onchange="handleChange(this);" @checked( $ruleStatus === 'true') />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <br>
                            <button id="employeePermissionSubmit" class="btn btn-sm btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
