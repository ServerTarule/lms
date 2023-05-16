@extends('layout.app')
@section('title', 'Manage Templates')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Templates</h4>
                        </a>
                    </div>
                </div>
                @if (session('status'))
                <span style="color:#00b100;">{{ session('status') }}</span>
            @endif
            @if (session('error'))
                <span style="color:#b10000;">{{ session('error') }}</span>
            @endif
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addTemplate"><i class="fa fa-plus"></i>
                            Add Template</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="tblheadclr1">
                                    <th scope="col">
                                        <a> S.No.</a>
                                    </th>
                                    <th scope="col">
                                        <a>Type</a>
                                    </th>
                                    <th scope="col">
                                        <a>Template Name</a>
                                    </th>
                                    <th scope="col">
                                        <a>Created Date</a>
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
                            @foreach ($templates as $template)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $template->type }}</td>
                                    <td>{{ $template->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($template->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#edititem" class="btn-xs btn-info"> <i class="fa fa-pencil"></i>  </a>
                                    </td>
                                    <td>
                                        <a href="#" id="deleteTemplate" onclick="deleteTemplate({{ $template->id }})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
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

    <div class="modal fade" id="addTemplate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i>ADD TEMPLATE</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{ route('templates.store') }}" method="POST">
                                @csrf
                                <fieldset>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Type</label>
                                        <select id="templateType" name="templateType" class="form-control">
                                            <option value="0">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Template</label>
                                        <input type="text" id="templateName" name="templateName" placeholder="Template" class="form-control">
                                    </div>
                                    <div id="templateSubjectDiv" class="col-md-12 form-group">
                                        <label class="control-label">Subject</label>
                                        <input type="text" id="templateEmailSubject" name="templateEmailSubject" placeholder="Please type here.." class="form-control">
                                    </div>
                                    <div id="templateMessageDiv" class="col-md-12 form-group">
                                        <label class="control-label">SMS/WhatsApp</label>
                                        <textarea class="form-control" id="templateMessage" name="templateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div id="templateEmailDiv" class="col-md-12 form-group">
                                        <label class="control-label">Email</label>
                                        <textarea class="form-control" id="templateEmailBody" name="templateEmailBody" placeholder="Please type here.."></textarea>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-add btn-sm">Save</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
