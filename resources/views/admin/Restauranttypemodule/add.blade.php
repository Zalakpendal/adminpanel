@extends('admin.layout.master')

@section('content')
<style>
    .title h2 {
        padding: 10px;
        font-size: 24px; /* Larger font size for the title */
        /* text-align: center; Center the title text */
    }

    .breadcrumb {
        margin-bottom: 20px;
    }

    .form-container {
        width: 100%;
        display: flex;
        justify-content: center; /* Center the form horizontally */
        padding: 20px;
        box-sizing: border-box;
    }

    .form {
        width: 100%;
        max-width: 800px; /* Adjust max-width to fit your design */
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        box-sizing: border-box;
    }

    .form-group {
        margin-bottom: 20px; /* Space between form groups */
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 16px; /* Adjust font size for clarity */
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px; /* Add border-radius for rounded corners */
        box-sizing: border-box; /* Include padding and border in width */
    }

    .form-group .required::after {
        content: '*';
        color: red;
        margin-left: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px; /* Space between buttons */
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

    strong {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form {
            padding: 20px;
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<div class="title">
    <h2>Restaurant Type</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.restaurant.list') }}">Restaurant Type</a></li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form action="{{ route('admin.restaurant.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="restaurant-type" class="required">Restaurant Type</label>
                <input type="text" id="restaurant-type" name="restaurant_type" required>
                @if ($errors->any())
                    <strong style="color:red">*Please enter Restaurant Type</strong>
                @endif
            </div>

            <div class="form-actions">
                <div class="buttons">
                    <button type="button" class="cancel"><a href="{{ route('admin.restaurant.list') }}">Cancel</a></button>
                    <button type="submit" class="save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
