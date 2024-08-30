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
    <h2>Roles</h2>
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
    <button class="btn" id="addtypes"><a href="{{url('role/create')}}">Add role</a></button>
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
            @foreach ($roles as $role)
            
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>
                    <a href="{{ url('role/'.$role->id.'/give-permissions')}}" class="btn btn-success">Add/Edit Role Permission</a>

                    @can('update role')
                    <a href="{{ url('role/'.$role->id.'/edit')}}" class="btn btn-success">Edit</a>
                    @endcan

                    @can('delete role')
                    <a href="{{url('role/'.$role->id.'/delete')}}" class="btn btn-danger mx-2">Delete</a>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $roles->onEachSide(1)->links() }}
    </div>
</div>
@endsection