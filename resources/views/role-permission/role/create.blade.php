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
    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 16px;
    }

    /* form{
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-sizing: border-box;
    } */
    input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 0;
        width: 400px; /* Approximate width for 50 characters */
        flex-grow: 1;
        border-color: #f44336;
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
    .submit-button{
        padding:7px 10px 7px 10px;
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
    <h2>Create Role</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>
<div class="actions">
    <button class="btn btn-primary" id="addtypes"><a href="{{url('role')}}">Back</a></button>
</div>
<div class="card-body">
    <form action="{{url('role')}}" method="POST">
    @csrf

    <div class="form-group">
        <label for="">Role Name<span class="required">*</span></label>
        <input type="text" name="name" class="form-control" maxlength="50">
        @if ($errors->any())
            <strong style="color:red">*Please enter Role Name</strong>
        @endif
        <button type="submit" class="submit-button">Save
        </button>
    </div>
    </form>
</div>

@endsection