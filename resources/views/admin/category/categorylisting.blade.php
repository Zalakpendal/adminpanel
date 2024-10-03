@extends('admin/layout/master')
@section('content')
<style>
    .title h2 {
        padding: 10px;
        font-size: 24px;
        color: #333;
    }

    .categorylisting {
        margin: 20px;
    }

    .actions {
        align-items: center;
        margin-bottom: 10px;
    }

    .actions .buttons {
        display: flex;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .search-input {
        border: 1px solid #ddd;
        padding: 5px;
        padding-left: 10px;
        border-radius: 4px 0 0 4px;
        border-right: none;
    }

    .btn {
        padding: 6px 15px;
        cursor: pointer;
        background-color: #4f6b7d;
        color: white;
        border: none;
        border-radius: 3px;
        text-align: center;
    }

    .btn:hover {
        background-color: #365163;
    }

    .buttons {
        float: right;
    }

    #addtypes a {
        color: white;
        text-decoration: none;
    }

    .action-icons {
        display: flex;
        gap: 15px;
        font-size: 18px;
    }

    .action-icons i {
        cursor: pointer;
        color: #4f6b7d;
    }

    .action-icons i:hover {
        color: #365163;
    }

    .buttons .btnsearch {
        border: 1px solid #ddd;
        border-radius: 0 4px 4px 0;
    }

    .edit,
    .delete,
    .statusbtn {
        border: none;
        background: none;
    }

    table {
        text-transform: capitalize;
    }

    .status-active {
        color: green;
        font-weight: bold;
    }

    .status-inactive {
        color: red;
        font-weight: bold;
    }

    .pagination {
        float: right;
        margin-top: 5px;
    }

    th .sortable {
        color: black;
    }



    table tbody tr:hover {
        background-color: #dcdcdc;
        cursor: pointer;
    }
</style>



<div class="title">
    <h2>Category List</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.categories.list')}}">Categorylist</a></li>
        <li class="breadcrumb-item">List</li>
    </ol>
</div>


<div class="categorylisting">
    <div class="actions">
        <form method="GET" action="{{ route('admin.categories.search') }}">
            <div class="buttons">
                <input type="text" placeholder="Search.." name="search" class="search-input"
                    value="{{ request()->query('search') }}">
                <button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>
            </div>
            <button class="btn" id="addtypes"><a href="{{ route('admin.categories.add') }}">Add</a></button>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.categories.list', ['sort' => 'categoryname', 'direction' => (request('sort') == 'categoryname' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Category Name
                        <i
                            class="fa {{ request('sort') == 'categoryname' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @if ($data->isEmpty())
        <tr>
            <td colspan="4" class="text-center">No records found</td>
        </tr>
        @else
            @foreach ($data as $category)
                <tr>
                    <td>{{$category->categoryname}}</td>
                    <td><img src="{{$category->image }}" alt="Image" style="width:50px; height:50px;"></td>
                    <td>
                        <span class="{{ $category->status == 1 ? 'status-active' : 'status-inactive' }}">
                            {{ $category->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons">
                            @can('update category')
                                <button class="edit"><a href="{{route('admin.categories.editform', [$category->id])}}"><i
                                            class="fas fa-edit"></i></a></button>
                            @endcan
                            <!-- <button class="delete"><a href="{{route('admin.categories.delete',[$category->id])}}"><i class="fas fa-trash-alt"></i></a></button> -->
                            @can('delete category')
                                <form action="{{ route('admin.categories.delete', [$category->id]) }}" method="get"
                                    class="delete-form" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="delete delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan
                            <form action="{{ route('admin.categories.toggleStatus', [$category->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="statusbtn">
                                    <i class="fas {{ $category->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="pagination">
        {{ $data->links() }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this offer!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endsection