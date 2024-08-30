@extends('admin/layout/master')

@section('content')
<style>
    .title h2 {
        padding: 10px;
    }
    .form {
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 18px;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
    }
    .buttons {
        display: flex;
        gap: 10px;
    }
    .cancel,
    .save {
        padding: 10px 15px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        color: white;
    }
    .cancel {
        background-color: #f44336;
    }
    .save {
        background-color: #3C5B6F;
    }
    .cancel:hover {
        background-color: #c62828;
    }
    .save:hover {
        background-color: #2c4a5f;
    }
    
    .images{
        display: flex;
        gap: 10px;
    }
    form{
        text-transform: capitalize;
    }
    
</style>

<div class="title">
    <h2>Edit Offer</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.offersofrestaurants.list') }}">Offers</a></li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>

<div class="form">
    <form action="{{ route('admin.offersofrestaurants.update', ['offer_id' => $offer->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="restaurant">Restaurant Name</label>
            <select id="restaurant" name="restaurant_id" required>
                <option value="" disabled>Select Restaurant</option>
                @foreach($restaurants as $id => $name)
                    <option value="{{ $id }}" {{ $offer->restaurant_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="offer_name">Offer Name</label>
            <input type="text" id="offer_name" name="offer_name" value="{{ $offer->offername }}" required>
        </div>

        <div class="form-group">
            <label for="coupon_no">Coupon Name</label>
            <input type="text" id="coupon_no" name="coupon_no" value="{{ $offer->coupon_no }}" required>
        </div>

        <div class="form-group">
            <label for="coupon_validity">Coupon Validity</label>
            <input type="date" id="coupon_validity" name="coupon_validity" value="{{ $offer->coupon_validity }}" required>
        </div>

        <div class="form-group">
            <label for="coupon_time">Coupon Time</label>
            <input type="text" id="coupon_time" name="coupon_time" value="{{ $offer->coupon_time }}" required>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" step="0.01" value="{{ $offer->amount }}" required>
        </div>

        <div class="form-group">
            <label for="minimum_price">Minimum Price</label>
            <input type="number" id="minimum_price" name="minimum_price" step="0.01" value="{{ $offer->minimum_price }}" required>
        </div>

        <div class="form-actions">
            <div class="buttons">
                <button type="button" class="cancel"><a href="{{ route('admin.offersofrestaurants.list') }}" style="color: white; text-decoration: none;">Cancel</a></button>
                <button type="submit" class="save">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
