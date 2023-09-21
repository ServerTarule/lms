@extends('layout.app')
@section('title', 'Rule')
@section('subtitle', 'Edit Rule')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="/rules/{{ $rule->id }}" class="btn btn-exp btn-sm">< Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bd drag">
                        <div class="panel-heading">
                            <div class="btn-group">
                                <a>
                                    <h4>Edit Rule</h4>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <input
                                    autocomplete="off"
                                    class="form-control ui-autocomplete-input"
                                    id="ruleName"
                                    name="Rule Name"
                                    placeholder="Rule Name"
                                    type="text"
                                    value="{{ $rule->name }}"
                                    readonly
                                />
                                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    @foreach($masters as $master)
                        <div class="col-md-3">
                            <div class="panel panel-bd">
                                <div class="panel-heading">
                                    <div class="btn-group">
                                        <a>
                                            <h4>{{ $master->name }}<span class="required"> * </span></h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <select class="form-control" name="ruleMaster" id="ruleMaster_{{ $master->id }}" multiple >
                                            <option disabled>-- Select Condition --</option>
                                            @foreach($master->values as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="col-md-1">
                                <div class="form-group">
                                    <small>Condition</small>
                                    <select class="form-control" data-val="true" name="ruleCondition_" id="ruleCondition_{{ $master->id }}" >
                                        <option disabled>--Select Condition--</option>
                                        <option value="or">OR</option>
                                        <option value="and">AND</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2 form-group">
                    <label class="control-label"><input type="radio" value="inbound" id="inboundRule" name="ruleType"/> Inbound</label>
                </div>
                <div class="col-md-2 form-group">
                    <label class="control-label"><input type="radio" value="outbound" id="outboundRule" name="ruleType" checked/>   Outbound</label>
                </div>
            </div>
            <div class="col-md-12" id="outboundDiv">
                <div class="col-md-2 form-group">
                    <label class="control-label">Frequency</label>
                    <input type="number" id="ruleFrequency" name="ruleFrequency" placeholder="Enter Frequency" value="{{$rule->rulefrequency or $rule->ruleFrequency}}" class="form-control">
                </div>
                <div class="col-md-2 form-group">
                    <label class="control-label">Schedule</label>
                    <select class="form-control" name="ruleSchedule" id="ruleSchedule" >
                        <option value="NA">-- Select Schedule --</option>
                        <option value="Day" @if($rule->ruleSchedule == 'Day') selected @endif>Day(s)</option>
                        <option value="Week"  @if($rule->ruleSchedule == 'Week') selected @endif>Week(s)</option>
                        <option value="Month"  @if($rule->ruleSchedule == 'Month') selected @endif>Month(s)</option>
                        <option value="Year"  @if($rule->ruleSchedule == 'Year') selected @endif>Year(s)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <button type="submit" id="editRuleConditionSubmit" class="btn btn-primary btn-sm">Submit</button>
                <button id="editRuleConditionClear" class="btn btn-danger btn-sm">Clear</button>
            </div>
        </div>
        <input name="ruleMasters" type="hidden" id="ruleMasters" value="{{ $masters }}">
        <input name="ruleId" type="hidden" id="ruleId" value="{{ $rule->id }}">
    </div>
@endsection
