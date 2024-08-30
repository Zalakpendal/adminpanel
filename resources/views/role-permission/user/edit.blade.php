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
    <h2>Edit User</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>
<div class="actions">
    <button class="btn" id="addtypes"><a href="{{ url('users') }}">Back</a></button>
</div>
<div class="card-body">
    <form action="{{ url('users/' . $user->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="mb-3">
            <label for="">User Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            @if ($errors->any())
                <strong style="color:red">*Please enter your name</strong>
                @endif
        </div>
        <div class="mb-3">
            <label for="">Email Name</label>
            <input type="text" name="email" class="form-control" readonly value="{{ $user->email }}">
            
        </div>
        <div class="mb-3">
            <label for="">Password</label>
            <input type="text" name="password" class="form-control">
            @if ($errors->any())
                <strong style="color:red">*Please enter your password</strong>
                @endif
        </div>
        <div class="mb-3">
            <label for="">Roles</label>
            <select name="roles[]" multiple class="form-control">
                @foreach($roles as $id => $name)
                    <option value="{{ $id }}" {{ in_array($id, $userRoles) ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->any())
                <strong style="color:red">*Please select the role</strong>
                @endif

        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
