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
    #searchbar{
        display: flex;
    }
    .btn-primary:hover {
        background-color: #004494;
    }
</style>

<div class="title">
    <h2>Roles</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>

<div class="search-bar">
<a href="{{ url('role/create') }}" class="btn btn-primary">Add Role</a>
    <form action="{{ url('role') }}" method="GET" id="searchbar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search roles...">
        <button type="submit">Search</button>
    </form>
    
</div>

<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($roles as $index => $role)
                <tr>
                <td>{{ $roles->firstItem() + $index }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a href="{{ url('role/' . $role->id . '/give-permissions') }}" class="btn btn-success">Add/Edit Role Permission</a>

                        @can('update role')
                            <a href="{{ url('role/' . $role->id . '/edit') }}" class="btn btn-success">Edit</a>
                        @endcan

                        <!-- @can('delete role') -->
                            <!-- <a href="{{ url('role/' . $role->id . '/delete') }}" class="btn btn-danger mx-2">Delete</a> -->
                            <!-- <button class="btn btn-danger mx-2" onclick="confirmDelete('{{ url('role/' . $role->id . '/delete') }}')">Delete</button> -->
                        <!-- @endcan -->
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No roles found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">
        {{ $roles->appends(['search' => request('search')])->onEachSide(1)->links() }}
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
