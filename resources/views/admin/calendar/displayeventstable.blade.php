@extends('admin/layout/master')

@section('content')
<style>
    .title {
        padding: 10px;
    }

    table {
        width: 80%;
        border-collapse: collapse;
        margin: 20px auto;
        text-transform: capitalize;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        margin-top: 30px;
        
    }
    

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        color: white;
    }

    .btn-edit {
        background-color: #007bff;
    }

    .btn-edit:hover {
        background-color: #0056b3;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }
    
</style>

<div class="title">
    <h2>All Events</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('admin.calendar.calendar')}}">Calendar</a></li>
    <li class="breadcrumb-item">All events</li>
    </ol>
</div>

<table>
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Color</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($events as $event)
        <tr>
            <!-- <td>{{ $event->id }}</td> -->
            <td>{{ $event->title }}</td>
            <td>{{ $event->start_date }}</td>
            <td>{{ $event->end_date }}</td>
            <td><span style="background-color: {{ $event->color }}; display: inline-block; width: 20px; height: 20px; border-radius: 50%;"></span></td>
            <td>
                <a href="{{ route('admin.calendar.edit', $event->id) }}" class="btn btn-edit">Edit</a>
                <!-- <form action="" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">Delete</button>
                </form> -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
