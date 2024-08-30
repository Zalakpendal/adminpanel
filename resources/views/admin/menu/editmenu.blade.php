@extends('admin.layout.master')

@section('content')
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 18px;
            color: #555;
            margin-bottom: 8px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .form-group input[type="file"] {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
            width: 100%;
        }

        .form-actions {
            margin-top: 20px;
            text-align: right;
        }

        .form-actions button {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        }

        .form-actions button[type="submit"] {
            background-color: #3C5B6F;
        }

        .form-actions button[type="submit"]:hover {
            background-color: #2c4a5f;
        }

        .form-actions button[type="button"] {
            background-color: #f44336;
        }

        .form-actions button[type="button"]:hover {
            background-color: #c62828;
        }
        .title h2 {
        padding: 10px;
        }
        .images{
        display: flex;
        gap: 10px;
        }
</style>

<div class="title">
    <h2>Edit Menu Item</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.allrestaurants.list') }}">Restaurants</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menuofrestaurants.list', ['id' => $restaurant->id]) }}">Menu</a></li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>

<div class="form-container">
    <form action="{{ route('admin.menuofrestaurants.updateform',['restaurant_id' => $menuItem->restaurant_id, 'menu_id' => $menuItem->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
            <div class="form-group">
            <label for="category_id">Select Category</label>
            <select name="category_id" id="category_id">
                <option value="" disabled>Select Category</option>
                @foreach($categories as $id => $category)
                <option value="{{ $id }}" {{ $menuItem->category_id == $id ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach 
            </select>
            </div>

            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name" value="{{ $menuItem->itemname}}" required>
            </div>

            <div class="form-group">
                <label for="item_price">Item Price</label>
                <input type="number" id="item_price" name="item_price" value="{{ $menuItem->price}}"  required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ $menuItem->description}}</textarea>
            </div>

            <div class="form-group">
            <label for="image">Image</label>
            <div class="images">
            <input type="file" id="image" name="image">
            @if ($menuItem->image)
                <img id="output" src="{{($menuItem->image) }}" style="width: 80px; height:50px;">
            @else
                <img id="output" style="width: 200px; display: none;">
            @endif
            </div>
            </div>

            <div class="form-actions">
                <button type="submit">Save</button>
                <button type="button">Cancel</button>
            </div>
    </form>
</div>
<script>
    var inputImage = document.getElementById('image');
    var outputImage = document.getElementById('output');

    inputImage.addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            outputImage.src = e.target.result;
            outputImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
    });
</script>
@endsection
