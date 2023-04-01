@extends('layout.app')
@section('title', 'Employee Leave Calendar')
@section('subtitle', 'Calendar View')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonexport">
                        <a>
                            <h4>Leaves</h4>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a class="btn btn-exp btn-sm" href="/leaves">< Back</a>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '8:00:00',
            slotMaxTime: '19:00:00',
            {{--events: @json($events),--}}
            eventSources: [
                @json($events),
                @json($holidays)
            ]
        });
        calendar.render();
    });
</script>
