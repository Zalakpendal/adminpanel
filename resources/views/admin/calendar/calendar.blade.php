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

    .hidden {
        display: none;
    }

    .fc-event-title {
        font-size: 16px;
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
    <a href="{{route('admin.calendar.list')}}" class="btn btn-secondary">Edit Event</a>
    <button id="deleteEventBtn" class="btn btn-danger hidden">Delete Event</button>
</div>
<div id="calendar"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            events: {!! json_encode($events) !!},
            eventClick: function (info) {
                const deleteEventBtn = document.getElementById('deleteEventBtn');
                deleteEventBtn.classList.remove('hidden');
                deleteEventBtn.setAttribute('data-id', info.event.id);
            }
        });

        calendar.render();

        document.getElementById('deleteEventBtn').addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this event!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/calendar/delete/${id}`; // Adjust URL as needed
                    }
                });
            }
        });
    });
</script>
@endsection