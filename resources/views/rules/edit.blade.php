@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <form method="post" action="{{ route('rules.update') }}" id="editRuleNameForm">
                @csrf
                <input type="hidden" name="editRuleId" id="editRuleId" value="{{ $rule->id }}">
                <div class="text-right">
                    <a href="/rules" class="btn btn-exp btn-sm">< Back</a>
                    <button type="submit" class="btn btn-exp btn-sm">Next</button>
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
                            <div class="panel-body">
                                <div class="form-group">
                                    <input
                                        autocomplete="off"
                                        class="form-control CityName ui-autocomplete-input"
                                        id="name"
                                        name="editRuleName"
                                        type="text"
                                        value="{{ $rule->name }}"
                                        required
                                    />
                                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="editRuleMasterRowCount" id="editRuleMasterRowCount" value=" {{ count($masters) }}">
                                    <table class="table table-bordered table-striped">
                                        <tr id="editRuleMasterHeaders">
                                            <th>S.No.</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
