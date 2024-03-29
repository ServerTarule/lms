@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <form method="post" onsubmit="return validateForm()" action="{{ route('rules.store') }}" id="ruleNameForm">
                @csrf
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
                                        data-val=""
                                        data-val-number=""
                                        id="name"
                                        name="ruleName"
                                        placeholder="Please enter rule name"
                                        type="text"
                                        value=""
                                        required

                                    />
                                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
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
                                                <select class="form-control" name="ruleMaster_1" id="ruleMaster_1" required>
                                                    <option selected disabled>--Select Condition--</option>
                                                    @foreach($masters as $master)
                                                    <option value="{{ $master -> id }}" >{{ $master -> name }}</option>
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-scripts')
<script type="text/javascript">
    function validateForm() {
        const name = $("#name").val();
        let jsonObject = [];
        let ruleMasterData = $('#ruleMasterRowCount').val();
        for( let i = 0;  i <= ruleMasterData; i++) {
            const ruleMasterVal = $('#ruleMaster_'+i).val();
            if (ruleMasterVal && ruleMasterVal != "--Select Condition--") {
                jsonObject.push($(ruleMasterVal).val());
            }
        }
        let isValid = true;
        let message ="";
        if(!name || name == "") {
            message  += "Please fill the name of rule.";
            isValid = false;
        }
        if(jsonObject.length == 0) {
            message  += "</br> Please select atleast one condition.";
            isValid = false;
        }
        if(isValid != true) {
            bootbox.alert(message);
            return false;
        }
        else {
            return true;
        }
    }

</script>
@endpush