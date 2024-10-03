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
        margin-bottom: 5px;
        display: flex;
        padding: 20px;
        justify-content: space-between;
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
        background-color: #0056b3;
    }
    #searchbar{
        display: flex;
    }
    .btn-primary{
        background-color: #0056b3;
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

<!-- <div class="toster">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
</div> -->

<div class="search-bar">
<a href="{{ url('permission/create') }}" class="btn btn-primary">Add Permission</a>
    <form action="{{ url('permission') }}" method="GET" id="searchbar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search permissions...">
        <button type="submit">Search</button>
    </form>
    
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
        @forelse ($permissions as $index => $permission)
                <tr>
                <td>{{ $permissions->firstItem() + $index }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <a href="{{ url('permission/' . $permission->id . '/edit') }}" class="btn btn-success">Edit</a>
                        <!-- <a href="{{ url('permission/' . $permission->id . '/delete') }}" class="btn btn-danger mx-2">Delete</a> -->
                        <button class="btn btn-danger mx-2" onclick="confirmDelete('{{ url('permission/' . $permission->id . '/delete') }}')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No permissions found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">
        {{ $permissions->appends(['search' => request('search')])->onEachSide(1)->links() }}
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

