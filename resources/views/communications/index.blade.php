@extends('layout.app')
@section('title', 'Email/WhatsApp Schedules')
@section('subtitle', 'List of Schedules')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a href="#">
                            <h4>Schedules</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" data-toggle="modal" data-target="#addSchedule"><i
                                class="fa fa-plus"></i> Schedule Action</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="tblheadclr1">
                                <th scope="col">
                                    <a>S.No.</a>
                                </th>
                                <th scope="col">
                                    <a>Rule</a>
                                </th>
                                <th scope="col">
                                    <a>Type</a>
                                </th>
                                <th scope="col">
                                    <a>Template Name</a>
                                </th>
                                <th scope="col">
                                    <a>Scheduled/Send Now</a>
                                </th>
                                <th scope="col">
                                    <a>Count</a>
                                </th>
{{--                                <th scope="col">--}}
{{--                                    <a>Date</a>--}}
{{--                                </th>--}}
{{--                                <th scope="col">--}}
{{--                                    <a>Time</a>--}}
{{--                                </th>--}}
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
                            @foreach ($communications as $communication)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $communication->rule?->name }}</td>
                                    <td>{{ $communication->type }}</td>
                                    <td>{{ $communication->template?->name }}</td>
                                    <td>{{ $communication->words }}</td>
                                    <td><a href="/communications/{{$communication->id}}/leads">{{ $communication->leads()->count() }}</a></td>
{{--                                    <td></td>--}}
{{--                                    <td>{{ \Carbon\Carbon::parse($holiday->day)->format('d/m/Y') }}</td>--}}
                                    <td>{{ \Carbon\Carbon::parse($communication->created_at)->format('d/m/Y') }}</td>
{{--                                    <td>--}}
{{--                                        <a href="#" data-toggle="modal" data-target="#editSchedule" id="editCommunicationSchedule" class="btn-xs btn-info"><i class="fa fa-edit"></i></a>--}}
{{--                                    </td>--}}
                                    <td>
                                        <a href="#" id="editCommunicationSchedule" onclick="editCommunication( {{ $communication->id }})" class="btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="deleteCommunication" onclick="deleteCommunication( {{ $communication->id }})" class="btn-xs btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSchedule" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Email/WhatsApp Scheduler</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{ route('communications.store') }}" method="POST">
                                @csrf
                                <fieldset>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Rule</label>
                                        <select name="ruleId" id="ruleId" class="form-control">
                                            <option>--Select Rule--</option>
                                            @foreach($rules as $rule)
                                                <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Type</label>
                                        <select id="communicationTemplateType" name="communicationTemplateType" class="form-control">
                                            <option value="NA">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Template</label>
                                        <select name="communicationTemplateId" id="communicationTemplateId" class="form-control">
                                            <option value="NA">--Select Template--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group" id="communicationTemplateSubjectDiv">
                                        <label class="control-label">Subject</label>
                                        <input class="form-control" type="text" name="communicationTemplateSubject" id="communicationTemplateSubject" placeholder="Please type here..">
                                    </div>
                                    <div class="col-md-12 form-group" id="communicationTemplateMessageDiv">
                                        <label class="control-label" id="control-label">WhatsApp</label>
                                        <textarea class="form-control" id="communicationTemplateMessage" name="communicationTemplateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-12 form-group" id="communicationTemplateBodyDiv">
                                        <label class="control-label">Email</label>
                                        <textarea class="form-control" id="communicationTemplateBody" name="communicationTemplateBody" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label"><input type="radio" value="scheduled" id="communicationSchedule" name="schedule" checked/>Scheduled</label>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label"><input type="radio" value="now" id="communicationNow" name="schedule"/>Send Now</label>
                                    </div>

                                    <div id="communicationScheduleDiv">

                                        <div class="col-md-3 form-group">
                                            <select name="scheduleUnit" id="scheduleUnit" class="form-control">
                                                <option value="0">--select--</option>
                                                <option value="DAILY">Daily</option>
                                                <option value="WEEKLY">Weekly</option>
                                                <option value="FORTNIGHTLY">Fortnightly</option>
                                                <option value="MONTHLY">Monthly</option>
                                                <option value="QUARTERLY">Quarterly</option>
                                                <option value="HALFYEARLY">Half Yearly</option>
                                                <option value="YEARLY">Yearly</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group" id="dayOfWeekDiv">
                                            <select id="dayOfWeek" name="dayOfWeek" class="form-control">
                                                <option value="NA">--Select Day--</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                                <option value="0">Sunday</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div id="communicationNowDiv">

                                        <div class="col-md-3 form-group" id="dayOfMonthDiv">
                                            <select id="dayOfMonth" name="dayOfMonth" class="form-control">
                                                <option value="NA">--Select Date--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="13">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="time" id="minuteHour" name="minuteHour" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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

    <div class="modal fade" id="editSchedule" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:850px!important;width: 100%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3><i class="fa fa-plus m-r-5"></i> Email/WhatsApp Scheduler</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{{ route('communications.update') }}" method="POST">
                                @csrf
                                <fieldset>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Rule</label>
                                        <select name="ruleId" id="ruleId" class="form-control ruleId">
                                            <option>--Select Rule--</option>
                                            @foreach($rules as $rule)
                                                <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Type</label>
                                        <select id="communicationTemplateType" name="communicationTemplateType" class="form-control communicationTemplateType">
                                            <option value="NA">--Select Type--</option>
                                            <option value="Email">Email</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Template</label>
                                        <select name="communicationTemplateId" id="communicationTemplateId" class="form-control communicationTemplateId">
                                            <option value="NA">--Select Template--</option>
                                            @foreach($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group communicationTemplateSubjectDiv" id="communicationTemplateSubjectDiv">
                                        <label class="control-label">Subject</label>
                                        <input class="form-control communicationTemplateSubject" type="text" name="communicationTemplateSubject" id="communicationTemplateSubject" placeholder="Please type here..">
                                    </div>
                                    <div class="col-md-12 form-group communicationTemplateMessageDiv" id="communicationTemplateMessageDiv">
                                        <label class="control-label" id="control-label">WhatsApp</label>
                                        <textarea class="form-control communicationTemplateMessage" id="communicationTemplateMessage" name="communicationTemplateMessage" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-12 form-group communicationTemplateBodyDiv" id="communicationTemplateBodyDiv">
                                        <label class="control-label">Email</label>
                                        <textarea class="form-control communicationTemplateBody" id="communicationTemplateBody" name="communicationTemplateBody" placeholder="Please type here.."></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label communicationSchedule"><input type="radio" value="scheduled" id="communicationSchedule" name="schedule" checked/>Scheduled</label>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label communicationNow"><input type="radio" value="now" id="communicationNow" name="schedule"/>Send Now</label>
                                    </div>

                                    <div id="editCommunicationScheduleDiv">

                                        <div class="col-md-3 form-group">
                                            <select name="scheduleUnit" id="scheduleUnit" class="form-control scheduleUnit">
                                                <option value="0">--select--</option>
                                                <option value="DAILY">Daily</option>
                                                <option value="WEEKLY">Weekly</option>
                                                <option value="FORTNIGHTLY">Fortnightly</option>
                                                <option value="MONTHLY">Monthly</option>
                                                <option value="QUARTERLY">Quarterly</option>
                                                <option value="HALFYEARLY">Half Yearly</option>
                                                <option value="YEARLY">Yearly</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group" id="dayOfWeekDiv">
                                            <select id="dayOfWeek" name="dayOfWeek" class="form-control dayOfWeek">
                                                <option value="NA">--Select Day--</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                                <option value="0">Sunday</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div id="editCommunicationNowDiv">

                                        <div class="col-md-3 form-group" id="dayOfMonthDiv">
                                            <select id="dayOfMonth" name="dayOfMonth" class="form-control dayOfMonth">
                                                <option value="NA">--Select Date--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="13">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="time" id="minuteHour" name="minuteHour" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
