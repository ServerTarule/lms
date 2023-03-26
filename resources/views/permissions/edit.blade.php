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
{{--                    <form method="post" action="/employees/permissions/{{ $employeeId }}" id="employeePermissionsForm">--}}
{{--                        @csrf--}}
                        <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">All</a></li>
    {{--                            <li><a href="#tab2" data-toggle="tab">Master</a></li>--}}
                                <li><a href="#masterTab" data-toggle="tab">Master</a></li>
                                <li><a href="#tab3" data-toggle="tab">Employee Management</a></li>
                                <li><a href="#tab4" data-toggle="tab">Lead Management</a></li>
                                <li><a href="#tab5" data-toggle="tab">SMS/Email Management</a></li>
                                <li><a href="#tab6" data-toggle="tab">Other Management</a></li>
    {{--                            <li><a href="#tab7" data-toggle="tab">Rules</a></li>--}}
                                <li><a href="#rulesTab" data-toggle="tab">Rules</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr class="info">
                                                    <th>S. No.</th>
                                                    <th>Menu</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Master</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Employee Management</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Lead Management</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>SMS/Email Management</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Other Management</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Rules</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="masterTab">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr class="info">
                                                    <th>S. No.</th>
                                                    <th>Menu</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($masters as $master)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $master->name }}</td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" checked />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <input type="checkbox" checked />
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
    {{--                                            <tr>--}}
    {{--                                                <td>1</td>--}}
    {{--                                                <td>Action Type</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>2</td>--}}
    {{--                                                <td>Lead Status</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>3</td>--}}
    {{--                                                <td>Lead Type</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>4</td>--}}
    {{--                                                <td>City</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>5</td>--}}
    {{--                                                <td>Location</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>6</td>--}}
    {{--                                                <td>Center Details</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>7</td>--}}
    {{--                                                <td>Sms/Email Template</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>8</td>--}}
    {{--                                                <td>Add Menu</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>9</td>--}}
    {{--                                                <td>Sub Menu</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>10</td>--}}
    {{--                                                <td>Social Integration</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>10</td>--}}
    {{--                                                <td>Create Designation</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>11</td>--}}
    {{--                                                <td>Grant Authority</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab3">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr class="info">
                                                    <th>S. No.</th>
                                                    <th>Menu</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
    {{--                                                <td>1</td>--}}
    {{--                                                <td>Employee Details</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab4">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr class="info">
                                                    <th>S. No.</th>
                                                    <th>Menu</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
    {{--                                            <tr>--}}
    {{--                                                <td>1</td>--}}
    {{--                                                <td>Add/Edit Lead</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>2</td>--}}
    {{--                                                <td>First Calling</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>3</td>--}}
    {{--                                                <td>Lead Follow Up</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>4</td>--}}
    {{--                                                <td>Master Data</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>5</td>--}}
    {{--                                                <td>Upload Data</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab5">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr class="info">
                                                    <th>S. No.</th>
                                                    <th>Menu</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
    {{--                                            <tr>--}}
    {{--                                                <td>1</td>--}}
    {{--                                                <td>SMS/Email In Bulk</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>2</td>--}}
    {{--                                                <td>Send Sms</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>3</td>--}}
    {{--                                                <td>Send Email</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>4</td>--}}
    {{--                                                <td>Send Details</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>5</td>--}}
    {{--                                                <td>Email Details</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab6">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr class="info">
                                                    <th>S. No.</th>
                                                    <th>Menu</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
    {{--                                            <tr>--}}
    {{--                                                <td>1</td>--}}
    {{--                                                <td>Lasik Blogs</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>2</td>--}}
    {{--                                                <td>Daily Quotes</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
    {{--                                            <tr>--}}
    {{--                                                <td>3</td>--}}
    {{--                                                <td>Occasion Details</td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" checked />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                                <td>--}}
    {{--                                                    <label class="switch">--}}
    {{--                                                        <input type="checkbox" />--}}
    {{--                                                        <span class="slider round"></span>--}}
    {{--                                                    </label>--}}
    {{--                                                </td>--}}
    {{--                                            </tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="rulesTab">
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
{{--                                                    {{ Form::hidden('employeePermissionRules', $rules) }}--}}
                                                    <input id="employeePermissionRules" type="hidden" value="{{ $rules }}" />
                                                    @foreach ($rules as $rule)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $rule->name }}</td>
                                                            <td>
                                                                <label class="switch">
                                                                    <input id="rule_{{ $rule->id }}" type="checkbox" checked />
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
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
