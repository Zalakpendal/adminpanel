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
    <h2>Add Restaurant</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route("admin.dashbord")}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.allrestaurants.list') }}">All Restaurant</a></li> 
        <li class="breadcrumb-item">Add</li>
    </ol>
</div>

<div class="form">
    <form action="{{ route('admin.allrestaurants.insert') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="restaurantName">Restaurant Name</label>
            <input type="text" id="restaurantName" name="restaurantName">
            @if ($errors->any())
                <strong style="color:red">*Please enter Restaurant Name</strong>
                @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            @if ($errors->any())
                <strong style="color:red">*Please enter Email</strong>
                @endif
        </div>

        <!-- <div class="form-group">
            <label for="restaurantType">Restaurant Type</label>
            <select id="restaurantType" name="restaurantType" required>
                <option value="" disabled selected>Select Type</option>
                <option value="fast_food">Fast Food</option>
                <option value="casual_dining">Casual Dining</option>
                <option value="fine_dining">Fine Dining</option>
                <option value="cafe">Café</option>
            </select>
        </div> -->
        <div class="form-group">
        <label for="restaurantType">Restaurant Type</label>
        <select id="restaurantType" name="restaurantType">
        <option value="" disabled selected>Select Type</option>
        @foreach($restaurantTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
        </select>
        </div>

        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" id="phoneNumber" name="phoneNumber">
            @if ($errors->any())
                <strong style="color:red">*Please enter Phone number</strong>
                @endif
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address">
            @if ($errors->any())
                <strong style="color:red">*Please enter Restaurant Address</strong>
                @endif
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>
            @if ($errors->any())
                <strong style="color:red">*Please enter about Restaurant</strong>
                @endif
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <div class="images">
            <input type="file" id="image" name="image">
            <img id="imagePreview" src="#" alt="Preview" style="width: 80px; height:50px; display: none;">
            @if ($errors->any())
                <strong style="color:red">*Please enter Your Restaurant's image</strong>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <div class="buttons">
                <button type="button" class="cancel"><a href="{{ route('admin.restaurant.list') }}" style="color: white; text-decoration: none;">Cancel</a></button>
                <button type="submit" class="save">Save</button>
            </div>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#image').change(function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#imagePreview').attr('src', reader.result).show();
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    });
</script>
@endsection
