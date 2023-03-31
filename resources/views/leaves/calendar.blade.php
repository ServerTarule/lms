@extends('layout.app')
@section('title', 'Employee Leave Calendar')
@section('subtitle', 'Calendar View')
@section('content')
    <div id="calendar"></div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '8:00:00',
            slotMaxTime: '19:00:00',
            events: @json($events),
        });
        calendar.render();
    });
</script>
