@extends('admin.layout.master')

@section('content')
<style>
    .title h2 {
        padding: 10px;
        font-size: 24px;
        color: #333;
    }

    .form-container {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .form {
        width: 100%;
        max-width: 960px; 
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        box-sizing: border-box;
        margin: 0 auto; 
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; 
        margin-bottom: 20px; 
    }

    .form-group {
        flex: 1;
        min-width: calc(50% - 20px); 
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 14px; 
    }

    .form-group label.required::after {
        content: '*';
        color: red;
        margin-left: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px; 
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; 
    }

    .form-group input::placeholder {
        color: #aaa; 
    }

    .form-group.error input,
    .form-group.error select,
    .form-group.error textarea {
        border-color: #f44336;
    }

    .form-group.error .error-message {
        color: #f44336;
        font-size: 14px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .buttons {
        display: flex;
        gap: 10px;
    }

    .cancel,
    .save {
        padding: 8px 12px; 
        cursor: pointer;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 14px;
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

    .buttons a {
        color: white;
        text-decoration: none;
    }

    .buttons a:hover {
        color: white;
    }
</style>

<div class="title">
    <h2>Add Offer</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.offersofrestaurants.list') }}">Offers</a></li>
        <li class="breadcrumb-item">Add</li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form action="{{ route('admin.offersofrestaurants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group {{ $errors->has('restaurant_id') ? 'error' : '' }}">
                    <label for="restaurant" class="required">Restaurant Name</label>
                    <select id="restaurant" name="restaurant_id">
                        <option value="" disabled selected>Select Restaurant</option>
                        @foreach($restaurants as $id => $restaurant)
                            <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>
                        @endforeach 
                    </select>
                    @if ($errors->has('restaurant_id'))
                        <div class="error-message">{{ $errors->first('restaurant_id') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('offer_name') ? 'error' : '' }}">
                    <label for="offer_name" class="required">Offer Name</label>
                    <input type="text" id="offer_name" maxlength="50" name="offer_name" placeholder="e.g., weekend offer" value="{{ old('offer_name') }}">
                    @if ($errors->has('offer_name'))
                        <div class="error-message">{{ $errors->first('offer_name') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('coupon_no') ? 'error' : '' }}">
                    <label for="coupon_name" class="required">Coupon Code</label>
                    <input type="text" id="coupon_name" maxlength="50" name="coupon_no" placeholder="e.g., Sunday2024" value="{{ old('coupon_no') }}">
                    @if ($errors->has('coupon_no'))
                        <div class="error-message">{{ $errors->first('coupon_no') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('start_date') ? 'error' : '' }}">
                    <label for="coupon_start_date" class="required">Start Date</label>
                    <input type="date" id="coupon_start_date" name="start_date" value="{{ old('start_date') }}">
                    @if ($errors->has('start_date'))
                        <div class="error-message">{{ $errors->first('start_date') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('coupon_validity') ? 'error' : '' }}">
                    <label for="coupon_validity" class="required">Coupon Validity</label>
                    <input type="date" id="coupon_validity" name="coupon_validity" value="{{ old('coupon_validity') }}">
                    @if ($errors->has('coupon_validity'))
                        <div class="error-message">{{ $errors->first('coupon_validity') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('coupon_time') ? 'error' : '' }}">
                    <label for="coupon_time" class="required">Coupon Time</label>
                    <input type="text" id="coupon_time" name="coupon_time" placeholder="e.g., 24hr" value="{{ old('coupon_time') }}">
                    @if ($errors->has('coupon_time'))
                        <div class="error-message">{{ $errors->first('coupon_time') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('amount') ? 'error' : '' }}">
                    <label for="amount" class="required">Amount</label>
                    <input type="text" id="amount" name="amount" maxlength="50" placeholder="e.g., 50% off" value="{{ old('amount') }}">
                    @if ($errors->has('amount'))
                        <div class="error-message">{{ $errors->first('amount') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('minimum_price') ? 'error' : '' }}">
                    <label for="minimum_price" class="required">Minimum Price</label>
                    <input type="number" id="minimum_price" name="minimum_price" min="0" placeholder="e.g., 100" value="{{ old('minimum_price') }}">
                    @if ($errors->has('minimum_price'))
                        <div class="error-message">{{ $errors->first('minimum_price') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <div class="buttons">
                    <button type="button" class="cancel"><a href="{{ route('admin.offersofrestaurants.list') }}" style="color: white; text-decoration: none;">Cancel</a></button>
                    <button type="submit" class="save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
