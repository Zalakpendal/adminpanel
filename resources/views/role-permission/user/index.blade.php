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

    .alert-success {
        padding: 5px;
    }

    .toster {
        padding: 10px;
    }

    .pagination {
        float: right;
        margin-top: 10px;
    }
    span {
        color: black; 
    }

    .sortable {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    .sortable i {
        margin-left: 5px;
        color: black;
    }
</style>

<div class="title">
    <h2>Users</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>
<div class="toster">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
</div>
<div class="actions">
    <button class="btn" id="addtypes"><a href="{{ url('users/create') }}">Add User</a></button>
</div>
<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('users.index', ['sort' => 'id', 'direction' => (request('direction') === 'asc' ? 'desc' : 'asc') ?? 'asc']) }}"
                        class="sortable">
                        <span> Id</span> 
                        <i
                            class="fa {{ request('sort') == 'id' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>

                <th>
            <a href="{{ route('users.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="sortable">
            <span> Name</span> 
                <i class="fa {{ request('sort') == 'name' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
            </a>
        </th>
        <th>
            <a href="{{ route('users.index', ['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="sortable">
            <span> Email </span> 
                <i class="fa {{ request('sort') == 'email' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
            </a>
        </th>
                <th>Roles</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $rolename)
                            <label for="badge bg-primary mx-1">{{$rolename}}</label>
                        @endforeach                    
                    @endif
                    </td>
                    <td>
                        @can('update user')
                            <a href="{{ url('users/' . $user->id . '/edit') }}" class="btn btn-success">Edit</a>
                        @endcan

                        @can('delete user')
                            <a href="{{ url('users/' . $user->id . '/delete') }}" class="btn btn-danger mx-2">Delete</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->onEachSide(1)->links() }}
    </div>
</div>
@endsection