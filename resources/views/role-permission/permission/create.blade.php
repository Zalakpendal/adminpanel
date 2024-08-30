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
    <h2>Create Permissions</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>
<div class="actions">
    <button class="btn" id="addtypes"><a href="{{url('permission')}}">back</a></button>
</div>
<div class="card-body">
    <form action="{{url('permission')}}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="">Permissions Name</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Save
        </button>
    </div>

    </form>
</div>

@endsection