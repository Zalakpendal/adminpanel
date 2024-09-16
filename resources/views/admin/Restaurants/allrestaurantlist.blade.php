@extends('admin/layout/master')
@section('content')
<style>
    .title h2 {
        padding: 10px;
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

    .fa-toggle-on {
        font-size: 20px;
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

    span {
        font-size: 14px;
    }

    .add-menu-btn {
        border: none;
        /* border: 1px solid #4f6b7d; */
        border-radius: 3px;
    }

    .add-menu-btn a {
        color: #4f6b7d;
    }

    .add-menu-btn:hover {
        background-color: #6196A6;
    }

    .status-active {
        color: green;
        font-weight: bold;
    }

    .status-inactive {
        color: red;
        font-weight: bold;
    }
    .pagination{
        float: right;
        margin-top: 10px;
    }
    th .sortable{
        color: black;
    }
    table tbody tr:hover {
    background-color: #dcdcdc; 
    cursor: pointer; 
}

</style>
<div class="title">
    <h2>Restaurant List</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route("admin.allrestaurants.list")}}">Restaurants</a></li>
        <li class="breadcrumb-item">List</li>
    </ol>
</div>

<div class="restaurantlisting">
    <form method="GET" action="{{ route('admin.allrestaurants.search') }}">
            <div class="buttons">
                <input type="text" placeholder="Search.." name="search" class="search-input" value="{{ request()->query('search') }}">
                <button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>
            </div>
            <button class="btn" id="addtypes"><a href="{{ route('admin.allrestaurants.add') }}">Add</a></button>
        </form>
    <table>
        <thead>
            <tr>
                <!-- <th>Restaurant Name</th> -->
                <th>
                    <a href="{{ route('admin.allrestaurants.list', ['sort' => 'restaurantname', 'direction' => (request('sort') === 'restaurantname' && request('direction') === 'asc') ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Restaurant Name
                        <i
                            class="fa {{ request('sort') === 'restaurantname' ? (request('direction') === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>Phone Number</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $restaurant)
                <tr>
                    <td>{{ $restaurant->restaurantname }}</td>
                    <td>{{ $restaurant->phonenumber }}</td>
                    <td><img src="{{$restaurant->image }}" alt="Image" style="width:50px; height:50px;"></td>
                    <td>
                        <span class="{{ $restaurant->status == 1 ? 'status-active' : 'status-inactive' }}">
                            {{ $restaurant->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons">
                            @can('update restaurant')
                            <button class="edit"> <a href="{{route('admin.allrestaurants.editform', [$restaurant->id])}}">
                                <i class="fas fa-edit"></i></a>
                            </button>
                            @endcan

                            @can('delete restaurant')
                            <form action="{{ route('admin.allrestaurants.delete', [$restaurant->id]) }}" method="get"
                                class="delete-form" style="display:inline;">
                                @csrf
                                <button type="submit" class="delete delete-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endcan

                            <form action="{{ route('admin.allrestaurants.toggleStatus', [$restaurant->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="statusbtn">
                                    <i
                                        class="fas {{ $restaurant->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                            </form>
                            <button class="add-menu-btn"> <a
                                    href="{{route('admin.menuofrestaurants.list', ['id' => $restaurant->id])}}"><i
                                        class="fas fa-arrow-alt-circle-right"></i></a></button>
                        </div>
                    </td>
                </tr>
            @endforeach
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