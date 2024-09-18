@extends('admin.layout.master')

@section('content')
<style>
    .title h2 {
        padding: 10px;
        font-size: 24px; /* Adjust font size for clarity */
    }

    .form-container {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .form {
        width: 100%;
        max-width: 960px; /* Adjust max-width to fit your design */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        box-sizing: border-box;
        margin: 0 auto; /* Center horizontally but respect max-width */
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Space between fields */
        margin-bottom: 20px; /* Space below form-row */
    }

    .form-group {
        flex: 1;
        min-width: calc(50% - 20px); /* Two columns with a gap */
        margin-bottom: 15px; /* Space below each form-group */
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 14px; /* Smaller font size for labels */
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
        padding: 8px; /* Reduced padding for more compact appearance */
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* Include padding and border in width */
    }

    .form-group input::placeholder {
        color: #aaa; /* Light color for placeholder text */
    }

    .form-group .error {
        color: red;
        font-size: 14px; /* Increase font size for better readability */
        font-weight: bold; /* Make the font bold for emphasis */
        margin-top: 5px;
        display: block;
        padding: 5px 0; /* Add padding for spacing */
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
        padding: 8px 12px; /* Adjusted padding */
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column; /* Stack fields vertically on small screens */
        }

        .form-group {
            min-width: 100%; /* Full width for each field */
        }
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

<div class="form-container">
    <div class="form">
        <form action="{{ route('admin.offersofrestaurants.update', ['offer_id' => $offer->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <!-- <div class="form-row">
                <div class="form-group">
                    <label for="restaurant" class="required">Restaurant Name</label>
                    <select id="restaurant" name="restaurant_id">
                        <option value="" disabled>Select Restaurant</option>
                        @foreach($restaurants as $id => $name)
                            <option value="{{ $id }}" {{ $offer->restaurant_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('restaurant_id')
                        <span class="error">*Please select a restaurant</span>
                    @enderror
                </div> -->
                <div class="form-row">
                <div class="form-group">
                    <label for="restaurant" class="required">Restaurant Name</label>
                    <select id="restaurant" name="restaurant_id">
                        <option value="" disabled>Select Restaurant</option>
                        @foreach($restaurants as $id => $name)
                            <option value="{{ $id }}" {{ $offer->restaurant_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('restaurant_id')
                        <span class="error">*Please select a restaurant</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="offer_name" class="required">Offer Name</label>
                    <input type="text" id="offer_name" name="offer_name" value="{{ $offer->offername }}" placeholder="e.g., Summer Sale">
                    @error('offer_name')
                        <span class="error">*Please enter offer name</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="coupon_no" class="required">Coupon Code</label>
                    <input type="text" id="coupon_no" name="coupon_no" value="{{ $offer->coupon_no }}" placeholder="e.g., SUMMER2024">
                    @error('coupon_no')
                        <span class="error">*Please enter coupon code</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date" class="required">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $offer->start_date }}">
                    @error('start_date')
                        <span class="error">*Please enter coupon start date</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="coupon_validity" class="required">Coupon Validity</label>
                    <input type="date" id="coupon_validity" name="coupon_validity" value="{{ $offer->coupon_validity }}">
                    @error('coupon_validity')
                        <span class="error">*Please enter coupon validity</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="coupon_time" class="required">Coupon Time</label>
                    <input type="text" id="coupon_time" name="coupon_time" value="{{ $offer->coupon_time }}" placeholder="e.g., 10:00 AM">
                    @error('coupon_time')
                        <span class="error">*Please enter coupon time</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="amount" class="required">Amount</label>
                    <input type="text" id="amount" name="amount" step="0.01" value="{{ $offer->amount }}" placeholder="e.g., 50">
                    @error('amount')
                        <span class="error">*Please enter amount</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="minimum_price" class="required">Minimum Price</label>
                    <input type="number" id="minimum_price" name="minimum_price" step="0.01" value="{{ $offer->minimum_price }}" placeholder="e.g., 100">
                    @error('minimum_price')
                        <span class="error">*Please enter minimum price</span>
                    @enderror
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
