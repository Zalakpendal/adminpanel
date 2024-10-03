@extends('admin/layout/master')

@section('content')
<style>
   .title h2 {
        padding: 10px;
        font-size: 24px;
        color: #333;
    }

    .actions {
        align-items: center;
        margin-bottom: 10px;
    }

    .actions .buttons {
        display: flex;
    }

    .btn-primary {
        background-color: #0056b3;
    }

    .btn-primary a {
        text-decoration: none;
        color: #fff;
    }

    .actions {
        padding: 10px;
        margin-left: 10px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 16px;
    }

    input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 0;
        width: 400px; /* Approximate width for 50 characters */
        flex-grow: 1;
    }

    .submit-button {
        padding: 7px 10px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        color: white;
        background-color: #3C5B6F;
    }

    .card-body {
        display: flex;
        justify-content: center;
    }

    .form-group {
        display: flex;
        align-items: center;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 6px;
        flex-direction: row;
        gap: 20px; /* Spacing between input and button */
    }

    .required {
        color: #f44336; /* Red color for required fields */
    }
</style>

<div class="title">
    <h2>Create Permissions</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>

<div class="actions">
    <button class="btn btn-primary" id="addtypes"><a href="{{ url('permission') }}">Back</a></button>
</div>

<div class="card-body">
    <form action="{{ url('permission') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Permissions Name <span class="required">*</span></label>
            <input type="text" name="name" maxlength="50" class="form-control" required>
            @if ($errors->any())
                <strong style="color:red">*Please enter Permission</strong>
            @endif
            <button type="submit" class="submit-button">Save</button>
        </div>
    </form>
</div>

@endsection
