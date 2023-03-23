@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <form method="post" action="{{ route('rules.store') }}" id="ruleNameForm">
                @csrf
                <div class="text-right">
                    <a href="/rules" class="btn btn-exp btn-sm">< Back</a>
    {{--                <a href="/rules/create/condition" class="btn btn-exp btn-sm">Next ></a>--}}
                    <button type="submit" class="btn btn-exp btn-sm">Next</button>
{{--                    <button class="btn btn-exp btn-sm" id="ruleNameNext">Next</button>--}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bd drag">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <a>
                                        <h4>Title</h4>
                                    </a>
                                </div>
                            </div>
{{--                            <form method="post" action="{{ route('rules.create') }}">--}}
{{--                                @csrf--}}
                                <div class="panel-body">
                                    <div class="form-group">
                                        <input
                                            autocomplete="off"
                                            class="form-control CityName ui-autocomplete-input"
                                            data-val=""
                                            data-val-number=""
                                            id="name"
                                            name="ruleName"
                                            placeholder="Rule Name"
                                            type="text"
                                            value=""
                                        />
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
    {{--                                    <input type="hidden" class="hdncityid" value="0" name="hdncityid"/>--}}
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="ruleMasterRowCount" id="ruleMasterRowCount" value="1">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                            <tr id="initial_1">
                                                <td>1</td>
                                                <td>
                                                    <select class="form-control" name="ruleMaster_1" id="ruleMaster_1">
                                                        <option selected disabled>-- Select Condition --</option>
                                                        @foreach($masters as $master)
                                                        <option value="{{ $master -> id }}">{{ $master -> name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button id="addRow" class="fa fa-plus btn btn-sm btn-primary" ></button>
                                                    <button id="removeRow" class="fa fa-minus btn btn-sm btn-danger" disabled></button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
