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
.alert-success{
    padding: 5px;
}
.toster{
    padding: 10px;
}
.pagination{
        float: right;
        margin-top: 10px;
    }
   
</style>

<div class="title">
    <h2>Permissions</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>
<div class="toster">
@if (session('status'))
    <div class="alert alert-success">{{session('status')}}</div>
@endif
</div>
<div class="actions">
    <button class="btn" id="addtypes"><a href="{{url('permission/create')}}">Add</a></button>
</div>
<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
            
            <tr>
                <td>{{$permission->id}}</td>
                <td>{{$permission->name}}</td>
                <td>
                    <a href="{{ url('permission/'.$permission->id.'/edit')}}" class="btn btn-success">Edit</a>
                    <a href="{{url('permission/'.$permission->id.'/delete')}}" class="btn btn-danger mx-2">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $permissions->onEachSide(1)->links() }}
    </div>
</div>
@endsection