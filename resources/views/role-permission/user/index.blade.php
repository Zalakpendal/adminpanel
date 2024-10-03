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

    table tbody tr:hover {
        background-color: #dcdcdc;
        cursor: pointer;
    }

    .search-bar {
        margin-bottom: 20px;
        display: flex;
        padding: 20px;
        justify-content: space-between;
        align-items: center;
    }

    .search-bar input {
        padding: 5px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        border: 1px solid #ccc;
    }

    .search-bar button {
        padding: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border: none;
        background-color: #0056b3;
        color: #fff;
        cursor: pointer;
    }

    .search-bar button:hover {
        background-color: #004494;
    }

    .btn-primary {
        background-color: #0056b3;
        border: none;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #004494;
    }
    #searchbar{
        display: flex;
    }
</style>

<div class="title">
    <h2>Users</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>

<div class="toster">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
</div>

<div class="search-bar">
<a href="{{ url('users/create') }}" class="btn btn-primary">Add User</a>
    <form action="{{ route('users.index') }}" method="GET" id="searchbar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users...">
        <button type="submit">Search</button>
    </form>
    
</div>

<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    <!-- <a href="{{ route('users.index', ['sort' => 'id', 'direction' => (request('direction') === 'asc' ? 'desc' : 'asc') ?? 'asc', 'search' => request('search')]) }}" class="sortable">
                        <span>Id</span>
                        <i class="fa {{ request('sort') == 'id' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a> -->
                    #
                </th>

                <th>
                    <a href="{{ route('users.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="sortable">
                        <span>Name</span>
                        <i class="fa {{ request('sort') == 'name' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>

                <th>
                    <a href="{{ route('users.index', ['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="sortable">
                        <span>Email</span>
                        <i class="fa {{ request('sort') == 'email' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>Restaurant name</th>
                <th>Roles</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($users as $index => $user)
                <tr>
                <td>{{ $users->firstItem() + $index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->restaurant ? $user->restaurant->restaurantname : 'No Restaurant' }}</td>
                    <td>
                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $rolename)
                                <label for="badge bg-primary mx-1">{{ $rolename }}</label>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @can('update user')
                            <a href="{{ url('users/' . $user->id . '/edit') }}" class="btn btn-success">Edit</a>
                        @endcan

                        @can('delete user')
                            <!-- <a href="{{ url('users/' . $user->id . '/delete') }}" class="btn btn-danger mx-2">Delete</a> -->
                            <button class="btn btn-danger mx-2" onclick="confirmDelete('{{ url('users/' . $user->id . '/delete') }}')">Delete</button>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->appends(['search' => request('search'), 'sort' => request('sort'), 'direction' => request('direction')])->onEachSide(1)->links() }}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't to delete this",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection
