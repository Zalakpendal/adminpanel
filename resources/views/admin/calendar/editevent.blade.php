@extends('admin/layout/master')

@section('content')
<style>
    .title {
        padding: 20px;
        text-align: center;
    }

    .addevent {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="color"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .form-group input[type="color"] {
        padding: 0;
        border: none;
        cursor: pointer;
    }

    button[type="submit"] {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .form-group .error {
        color: red;
        font-size: 14px;
    }
</style>

<div class="title">
    <h2>Add Event</h2>
</div>

<div class="addevent">
    <form action="{{ route('admin.calendar.update', $event->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Event Name</label>
            <input type="text" id="title" name="title" value="{{ $event->title }}" required>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date"  value="{{ $event->start_date}}" required>
            @error('start_date')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date"  value="{{ $event->end_date}}" required>
            @error('end_date')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="color" id="color" name="color" value="{{ $event->color }}">
        </div>
        <button type="submit">Save Event</button>
    </form>
</div>
@endsection
