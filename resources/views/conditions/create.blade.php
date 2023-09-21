@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="{{ asset('rules.create') }}" class="btn btn-exp btn-sm"><i class="fa fa-eye"></i>< Back</a>
{{--                <a href="{{ asset('{{  route('rules.create.condition', compact('ruleName', 'ruleMaster')) }}') }}" class="btn btn-exp btn-sm"><i class="fa fa-eye"></i>< Back</a>--}}
            </div>
            <div class="row">
{{--                <form method="post" id="ruleConditionForm" name="ruleConditionForm" action="/rules/create/condition">--}}
{{--                    @csrf--}}
                    <div class="col-md-12">
                        <div class="panel panel-bd drag">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <a>
                                        <h4>Title</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <input
                                        autocomplete="off"
                                        class="form-control ui-autocomplete-input"
                                        data-val=""
                                        data-val-number=""
                                        id="ruleName"
                                        name="Rule Name"
                                        placeholder="Rule Name"
                                        type="text"
                                        value="{{ $ruleName }}"
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
                                        <select class="form-control" name="ruleMaster" id="ruleMaster_{{ $master -> id }}" multiple >
                                            <option disabled>-- Select Condition --</option>
                                            @php
                                                $values = $master->values()->get();
                                            @endphp
                                            @foreach($values as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
{{--                                        <select class="form-control" name="ruleMaster" id="ruleMaster_{{ $master -> id }}" @if($master -> id != 99) multiple @endif >--}}
{{--                                            <option disabled>-- Select Condition --</option>--}}
{{--                                            @php--}}
{{--                                                $values = $master->values()->get();--}}
{{--                                            @endphp--}}
{{--                                            @foreach($values as $value)--}}
{{--                                                <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                            @foreach($mainmasters as $mainmasters)--}}
{{--                                                <option     value="{{ $mainmasters -> id }}">{{ $mainmasters -> name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <div class="col-md-1">
                            <div class="form-group">
                                <small>Condition</small>
                                <select class="form-control" data-val="true" data-val-number="The field TreatmentType must be a number." id="ruleCondition_{{ $master -> id }}" name="ruleCondition">
                                    <option disabled>--Select Condition--</option>
                                    <option value="or">OR</option>
                                    <option value="and">AND</option>
{{--                                    <option value="union">UNION</option>--}}
{{--                                    <option value="minus">MINUS</option>--}}
                                </select>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                        <div class="col-md-12">
                            <div class="col-md-2 form-group">
                                <label class="control-label"><input type="radio" value="inbound" id="inboundRule" name="ruleType" checked/> Inbound</label>
                            </div>
                            <div class="col-md-2 form-group">
                                <label class="control-label"><input type="radio" value="outbound" id="outboundRule" name="ruleType" />   Outbound</label>
                            </div>
                        </div>
                        <div class="col-md-12" id="outboundDiv">
                            <div class="col-md-2 form-group">
                                <label class="control-label">Frequency</label>
                                <input type="number" id="ruleFrequency" name="ruleFrequency" placeholder="Enter Frequency" class="form-control">
                            </div>
                            <div class="col-md-2 form-group">
                                <label class="control-label">Schedule</label>
                                <select class="form-control" name="ruleSchedule" id="ruleSchedule" >
                                    <option value="NA">-- Select Schedule --</option>
                                    <option value="Day">Day(s)</option>
                                    <option value="Week">Week(s)</option>
                                    <option value="Month">Month(s)</option>
                                    <option value="Year">Year(s)</option>
                                </select>
                            </div>
                        </div>
                    </div>

{{--                <div>--}}
{{--                    <div class="col-md-1"></div>--}}
{{--                    <div class="col-md-3">--}}
{{--                        <div class="panel panel-bd">--}}
{{--                            <div class="panel-heading">--}}
{{--                                <div class="btn-group">--}}
{{--                                    <a>--}}
{{--                                        <h4>Date Range<span class="required"> * </span></h4>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="panel-body">--}}
{{--                                <div class="form-group">--}}
{{--                                    <select class="form-control" name="ruleMasterDateRange" id="ruleMasterDateRange">--}}
{{--                                        <option value="NA">-- Select Date Range --</option>--}}
{{--                                        <option value="7">7 DAYS</option>--}}
{{--                                        <option value="14">14 DAYS</option>--}}
{{--                                        <option value="30">1 MONTH</option>--}}
{{--                                        <option value="60">2 MONTHS</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="submit" id="ruleConditionSubmit" class="btn btn-primary btn-sm">Submit</button>
                            <button id="ruleConditionClear" class="btn btn-danger btn-sm">Clear</button>
                        </div>
                    </div>

                    <input type="hidden" name="ruleMasters" id="ruleMasters" value="{{ $masters }}">
{{--                </form>--}}
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
    $( document ).ready(function() {
        function disableOutbound(){
            $("#outboundDiv *").prop('disabled',true);
            $("#ruleFrequency").val('');
            $("#ruleSchedule").val('NA');
        }
        $("#inboundRule").click(function() {
            disableOutbound();
        });

        $("#outboundRule").click(function() {
            $("#outboundDiv *").prop('disabled',false);
        });

        disableOutbound();     
    });
   

</script>
@endpush
