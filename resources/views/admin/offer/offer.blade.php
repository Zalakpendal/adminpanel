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
        align-items: center;
    }

    .action-icons a,
    .action-icons button {
        background: none;
        border: none;
        cursor: pointer;
        color: #4f6b7d;
    }

    .action-icons a:hover,
    .action-icons button:hover {
        color: #365163;
    }

    .buttons .btnsearch {
        border: 1px solid #ddd;
        border-radius: 0 4px 4px 0;
    }

    .fa-toggle-on,
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

    .status-active {
        color: green;
        font-weight: bold;
    }

    .status-inactive {
        color: red;
        font-weight: bold;
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
    <h2>Offers List</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.offersofrestaurants.list') }}">Offers</a></li>
        <li class="breadcrumb-item">List</li>
    </ol>
</div>

<div class="restaurantlisting">
    <!-- <div class="actions">
        <div class="buttons">
            <input type="text" placeholder="Search.." name="search" class="search-input">
            <button type="button" class="btnsearch"><i class="fa fa-search"></i></button>
        </div>
        <button class="btn" id="addtypes"><a href="{{ route('admin.offersofrestaurants.add') }}">Add</a></button>
    </div> -->
    <div class="actions">
        <form method="GET" action="{{ route('admin.offersofrestaurants.search') }}">
            <div class="buttons">
                <input type="text" placeholder="Search.." name="search" class="search-input"
                    value="{{ request('search') }}">
                <button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>
            </div>
            <button class="btn" id="addtypes"><a href="{{ route('admin.offersofrestaurants.add') }}">Add</a></button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
            <th>Restaurant Name</th> 
            <th>Offer Name</th> 

                  <th>
                <a href="{{ route('admin.offersofrestaurants.list', ['sort' => 'start_date', 'direction' => request('sort') == 'start_date' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                   class="sortable">
                    Start-Date
                    <i class="fa {{ request('sort') == 'start_date' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                </a>
            </th>

                <th>
                    <a href="{{ route('admin.offersofrestaurants.list', ['sort' => 'coupon_validity', 'direction' => request('sort') == 'coupon_validity' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Coupon Validity
                        <i
                            class="fa {{ request('sort') == 'coupon_validity' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.offersofrestaurants.list', ['sort' => 'coupon_time', 'direction' => request('sort') == 'coupon_time' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Coupon Time
                        <i
                            class="fa {{ request('sort') == 'coupon_time' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.offersofrestaurants.list', ['sort' => 'amount', 'direction' => request('sort') == 'amount' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Amount
                        <i
                            class="fa {{ request('sort') == 'amount' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.offersofrestaurants.list', ['sort' => 'minimum_price', 'direction' => request('sort') == 'minimum_price' && request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                        class="sortable">
                        Minimum Price
                        <i
                            class="fa {{ request('sort') == 'minimum_price' ? (request('direction') == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>
                    </a>
                </th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @if ($offers->isEmpty())
        <tr>
            <td colspan="9" class="text-center">No records found</td>
        </tr>
        @else
            @foreach($offers as $offer)
                <tr>
                    <td>{{ $offer->restaurant->restaurantname }}</td>
                    <td>{{ $offer->offername }}</td>
                    <td>{{$offer->start_date}}</td>
                    <td>{{ $offer->coupon_validity }}</td>
                    <td>{{ $offer->coupon_time }}</td>
                    <td>{{ $offer->amount }}</td>
                    <td>{{ $offer->minimum_price }}</td>
                    <!-- <td>
                        <span class="{{ $offer->status == 'active' ? 'status-active' : 'status-inactive' }}">
                            {{($offer->status) }}
                        </span>
                    </td> -->
                    <td>
                        <span class="{{ $offer->status == 1 ? 'status-active' : 'status-inactive' }}">
                            {{ $offer->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-icons">
                            @can('update offer')
                                <a href="{{ route('admin.offersofrestaurants.editform', ['offer_id' => $offer->id]) }}"
                                    class="edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan

                            @can('delete offer')
                                <form action="{{ route('admin.offersofrestaurants.delete', ['offer_id' => $offer->id]) }}"
                                    method="get" class="delete-form" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="delete delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan

                            <form action="{{ route('admin.offersofrestaurants.changeStatus', ['offer_id' => $offer->id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="statusbtn">
                                    <i class="fas {{ $offer->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
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
        {{ $offers->appends(request()->except('page'))->onEachSide(1)->links() }}
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