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
    .permission-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }
    .permission-card input[type="checkbox"] {
        margin-right: 10px;
        transform: scale(1);
    }
    .permissionlable{
        margin-bottom: 20px;
        font-size: 20px;
        color: #3C3D37;
    }
    
</style>
@if (session('status'))
    <div class="alert alert-success">{{session('status')}}</div>
@endif
<div class="title">
    <h2>Role:{{$role->name}}</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>
<div class="actions">
    <button class="btn" id="addtypes"><a href="{{url('role')}}">back</a></button>
</div>

<div class="card-body">
    <form action="{{url('role/'.$role->id.'/give-permissions')}}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-2">
        @error('permission')
        <span class="text-danger">{{$message}}</span>
        @enderror
        <label class="permissionlable">List Of Permissions</label>

        <div class="row">
            @foreach ($permissions as $permission)
            <div class="col-md-3 mb-3">
            <div class="permission-card">
                <label>
                    <input  
                        type="checkbox"
                        name="permission[]" 
                        value="{{$permission->name}}" 
                        {{in_array($permission->id,$rolePermissions)? 'checked':''}}
                        />

                    {{$permission->name}}
                </label>
            </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Update
        </button>
    </div>

    </form>
</div>

@endsection