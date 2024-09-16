@extends('admin/layout/master')
@section('content')
<style>
    .title h2 {
        padding: 10px;
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
        font-size: 18px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
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
    .submit-button {
        padding: 10px 15px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        color: white;
        background-color: #3C5B6F;
        float: right;
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
    <button class="btn btn-primary" id="addtypes"><a href="{{url('role')}}">back</a></button>
</div>
<div class="card-body">
    <form action="{{url('role')}}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="">Role Name</label>
        <input type="text" name="name" class="form-control">
        @if ($errors->any())
            <strong style="color:red">*Please enter Role Name</strong>
        @endif
    </div>
    <div class="mb-3">
        <button type="submit" class="submit-button">Save
        </button>
    </div>

    </form>
</div>

@endsection