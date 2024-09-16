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
</style>

<div class="title">
    <h2>Create User</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>
<div class="actions">
    <button class="btn" id="addtypes"><a href="{{url('users')}}">back</a></button>
</div>
<div class="card-body">
    <form action="{{url('users')}}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="">User Name</label>
        <input type="text" name="name" class="form-control">
        @if ($errors->any())
            <strong style="color:red">*Please enter User Name</strong>
        @endif
    </div>
    <div class="mb-3">
        <label for="">Email Name</label>
        <input type="text" name="email" class="form-control">
        @if ($errors->any())
            <strong style="color:red">*Please enter Email</strong>
        @endif
    </div>
    <div class="mb-3">
        <label for="">Password</label>
        <input type="text" name="password" class="form-control">
        @if ($errors->any())
            <strong style="color:red">*Please enter password</strong>
            @endif
    </div>
    <div class="mb-3">
        <label for="">Roles</label>
        <select name="roles[]" class="form-control" multiple>
            <option value="">Select Role</option>
            @foreach ($roles as $id => $name)
            <option value="{{$id}}"> {{$name}} </option>
            @endforeach
        </select>
        <!-- <input type="text" name="name" class="form-control"> -->
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Save
        </button>
    </div>
    </form>
</div>

@endsection