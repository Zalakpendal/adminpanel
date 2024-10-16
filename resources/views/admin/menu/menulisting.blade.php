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

    .fa-toggle-off {
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

<div class="title">
    <h2>{{ $restaurant->restaurantname }}:menu</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route("admin.allrestaurants.list")}}">Restaurants</a></li>
        <li class="breadcrumb-item">Menu</li>
    </ol>
</div>

<div class="restaurantlisting">


    
    <form method="GET" action="{{ route('admin.menuofrestaurants.search', ['id' => $restaurant->id]) }}">
        <div class="buttons">
            <input type="text" name="search" placeholder="Search.." class="search-input"
                value="{{ request('search') }}">
            <button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>
        </div>
        <button class="btn" id="addtypes"><a
                href="{{ route('admin.menuofrestaurants.add', ['id' => $restaurant->id]) }}">Add</a></button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Category Name</th>
                <th>
                    <a href="{{ route('admin.menuofrestaurants.list', ['id' => $restaurant->id, 'sort' => 'itemname', 'direction' => (request('sort') === 'itemname' && request('direction') === 'asc') ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Item Name
                        <i
                            class="fa {{ request('sort') == 'itemname' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.menuofrestaurants.list', ['id' => $restaurant->id, 'sort' => 'price', 'direction' => (request('sort') === 'price' && request('direction') === 'asc') ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Price
                        <i
                            class="fa {{ request('sort') == 'price' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($menuItems->isEmpty())
                <tr>
                    <td colspan="9" class="text-center">No records found</td>
                </tr>
            @else
                @foreach($menuItems as $menuItem)
                    <tr>
                        <td>{{ $menuItem->category->categoryname }}</td>
                        <td>{{ $menuItem->itemname }}</td>
                        <td>{{ $menuItem->price }}</td>
                        <td><img src="{{$menuItem->image }}" alt="Image" style="width:50px; height:50px;"
                        onclick="showDetails('{{ asset( $menuItem->image) }}')"></td>
                        <td>
                            <span class="{{ $menuItem->status == 1 ? 'status-active' : 'status-inactive' }}">
                                {{ $menuItem->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-icons">
                                <!-- <button class="edit"> <a href=""> <i class="fas fa-edit"></i></a></button>  -->
                                @can('update menu')
                                    <a href="{{ route('admin.menuofrestaurants.editform', ['restaurant_id' => $restaurant->id, 'menu_id' => $menuItem->id]) }}"
                                        class="edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan 

                                @can('delete menu')
                                    <form
                                        action="{{ route('admin.menuofrestaurants.delete', ['restaurant_id' => $menuItem->restaurant_id, 'menu_id' => $menuItem->id]) }}"
                                        method="get" class="delete-form" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="delete delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endcan

                                <form
                                    action="{{ route('admin.menuofrestaurants.toggleStatus', ['restaurant_id' => $restaurant->id, 'menu_id' => $menuItem->id]) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="statusbtn">
                                        <i class="fas {{ $menuItem->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="pagination">
        {{ $menuItems->onEachSide(1)->links() }}
    </div>
</div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img title="Preview" width="100%" class="image_upload_preview" src="" alt="Preview">
            </div>
        </div>
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