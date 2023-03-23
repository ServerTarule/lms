@extends('layout.app')
@section('title', 'Rules & Regulations')
@section('subtitle', 'List of Rules & Regulations')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Status</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" href="/rules/create"><i class="fa fa-plus"></i> Add
                            Condition</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    S.No.
                                </th>
                                <th scope="col">
                                    <a>Date</a>
                                </th>
                                <th scope="col">
                                    <a>Title</a>
                                </th>
                                <th scope="col">
                                    <a>No. of Master</a>
                                </th>
                                <th scope="col">
                                    <a>Apply On Destination</a>
                                </th>
                                <th scope="col">
                                    <a>Edit</a>
                                </th>
                                <th scope="col">
                                    <a>Delete</a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rules as $rule)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rule->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $rule->name }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a href="/rules/{{$rule->id}}" class="btn-xs btn-info"> <i
                                                class="fa fa-edit"></i> </a>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Are you sure want to delete this?')"
                                           class="btn-xs btn-info" style="background: red;"> <i
                                                class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
