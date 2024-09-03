@extends('admin/layout/master')

@section('content')
<style>
    .title {
        padding: 10px;
    }

    .buttons {
        padding: 5px;
    }

    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>

<div class="title">
    <h2>Events</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    <li class="breadcrumb-item">Calendar</li>
    </ol>
</div>

<div class="buttons">
    <a href="{{ route('admin.calendar.create') }}" class="btn btn-primary">Add Event</a>
    <a href="{{route('admin.calendar.list')}}"class="btn btn-secondary">Edit Event</a>
    <button id="deleteEventBtn" class="btn btn-danger">Delete Event</button>
</div>

<!-- Calendar container -->
<div id="calendar"></div>

<!-- Include FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<style>
    .fc-event-title{
        font-size: 16px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            events: {!! json_encode($events) !!},
        });

        calendar.render();
    });
</script>
@endsection
