@extends('layout.app')
@section('title', 'List Upload')
@section('subtitle', 'List of leads')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Lead Upload File</h4>
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="col-md-12 form-group">
                                <label class="control-label">Choose Excel File </label>
                                <input type="file" placeholder="Enter Source " class="form-control" />
                            </div>
                            <div class="col-md-12 form-group">
                                <div>
                                    <button type="submit" class="btn btn-add btn-sm">Upload Excel</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
