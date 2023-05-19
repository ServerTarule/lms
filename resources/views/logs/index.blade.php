@extends('layout.app')
@section('title', 'Logs')
@section('subtitle', 'Logs')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd drag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Log status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel panel-bd drag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="#">
                                            <h4>Data</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <ul class="timeline">

                                            @foreach($audits as $key => $value)
                                            <li class="task active">
                                                <div class="badge"></div>
                                                <div class="timeline-body">
                                                    <div class="row">
                                                        <div class="col-left">
                                                            @php
                                                                foreach ($value as $k=>$v) {
                                                                    if ($k == 'id') {
                                                            @endphp
                                                            <h4 class="title">Lead - {{$v}}</h4>
                                                            @php
                                                                    }
                                                                    if ($k == 'old') {
                                                                        $oldValues = $v;
                                                                        foreach ($oldValues as $oKey => $oValue) {
                                                            @endphp
                                                            <p class="timeline-content"><strong>Old {{$oKey}} : {{ $oValue }}</strong></p>
                                                            @php
                                                                }
                                                                    }
                                                                    if ($k == 'new') {
                                                                        $newValues = $v;
                                                                        foreach ($newValues as $nKey => $nValue) {
                                                            @endphp
                                                            <p class="timeline-content"><strong>New {{$nKey}} : {{ $nValue }}</strong></p>
                                                            @php
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="panel panel-bd drag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="#">
                                            <h4>Filter</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="text-right">
                                        <form action="edit_package.php" method="post">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <select class="form-control">
                                                        <option selected disabled>--Select Rule--</option>
                                                        <option>--Rule--</option>
                                                        <option>--Rule--</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <input type="text" name="" class="form-control" placeholder="Lead Id">
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <input type="text" name="" class="form-control" placeholder="Mobile Number">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="date" name="" class="form-control">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="date" name="" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <input type="submit" name="" class="btn btn-primary btn-sm w-100">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
