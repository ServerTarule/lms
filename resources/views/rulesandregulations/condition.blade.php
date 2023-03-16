@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-right">
                <a href="ruleandregulation.php" class="btn btn-exp btn-sm">< Back</a> <a
                    href="add-ruleandregulation.php" class="btn btn-exp btn-sm">Next ></a>
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
                                    data-val=""
                                    data-val-number=""
                                    id="City"
                                    name="City"
                                    placeholder="Condition Name"
                                    type="text"
                                    value=""
                                />
                                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                <input type="hidden" class="hdncityid" value="0" name="hdncityid"/>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr id="initial">
                                        <td>1</td>
                                        <td>
                                            <select class="form-control">
                                                <option selected disabled>-- Select Condition --</option>
                                                @foreach($masters as $master)
                                                <option value="{{ $master -> id }}">{{ $master -> name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button class="fa fa-plus btn btn-sm btn-primary" id="addRow"></button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
