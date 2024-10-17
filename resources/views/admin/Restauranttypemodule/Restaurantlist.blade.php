@extends('admin/layout/master')

@section('content')
<style>
    .title h2 {
        padding: 10px;
        font-size: 24px;
        color: #333;
    }

    .restaurantlisting {
        margin: 20px;
    }

    .buttons {
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
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .search-input {
        border: 1px solid #ddd;
        padding: 4px;
        padding-left: 10px;
        border-radius: 4px 0 0 4px;
        border-right: none;
    }

    .btn {
        padding: 4px 15px;
        cursor: pointer;
        background-color: #4f6b7d;
        color: white;
        border: none;
        border-radius: 3px;
        text-align: center;
    }


    .btn:hover {
        background-color: #365163;
        color: white;
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

    .fa-toggle-on {
        font-size: 20px;
    }

    .edit,
    .delete,
    .statusbtn {
        border: none;
        background-color: #f2f2f2;
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
        margin-top: 10px;
    }

    th .sortable {
        color: black;
    }

    table tbody tr:hover {
        background-color: #dcdcdc;
        cursor: pointer;
    }
</style>


<!-- for toastr -->
@if($message = Session::get('success'))
    <div class="alert alert-success alert-block" id="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>{{$message}}</strong>
    </div>
@endif

@if($message = Session::get('error'))
    <div class="alert alert-danger alert-block" id="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>{{$message}}</strong>
    </div>
@endif

<div class="title">
    <h2>Restaurant Type</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.restaurant.list') }}">Restaurant Type</a></li>
        <li class="breadcrumb-item">List</li>
    </ol>
</div>

<div class="restaurantlisting">
    <form method="GET" action="{{ route('admin.restaurant.search') }}">
        <div class="buttons">
            <input type="text" placeholder="Search.." name="search" class="search-input"
                value="{{ request()->query('search') }}">
            <button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>
        </div>
        <button class="btn" id="addtypes"><a href="{{ route('admin.restaurant.add') }}">Add</a></button>
    </form>
    <table>
        <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.restaurant.list', ['sort' => 'restauranttype', 'direction' => (request('sort') == 'restauranttype' && request('direction') === 'asc') ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Restaurant Type
                        <i
                            class="fa {{ request('sort') == 'restauranttype' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @if ($data->isEmpty())
        <tr>
            <td colspan="3" class="text-center">No records found</td>
        </tr>
        @else
            @foreach ($data as $restauranttype)
            <tr>
                <td>{{ $restauranttype->restauranttype }}</td>
                <td>
                    <span class="{{ $restauranttype->status == 1 ? 'status-active' : 'status-inactive' }}">
                        {{ $restauranttype->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td>
                    <div class="action-icons">
                        <button class="edit">
                            @can('update restauranttype')
                                <a href="{{ route('admin.restaurant.editform', [$restauranttype->id]) }}"><i
                                        class="fas fa-edit"></i></a>
                            @endcan
                        </button>
                        @can('delete restauranttype')
                            <form action="{{ route('admin.restaurant.delete', [$restauranttype->id]) }}" method="get"
                                class="delete-form" style="display:inline;">
                                @csrf
                                <button type="submit" class="delete delete-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endcan

                        <form action="{{ route('admin.restaurant.toggleStatus', [$restauranttype->id]) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="statusbtn">
                                <i
                                    class="fas {{ $restauranttype->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
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