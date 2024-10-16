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
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-sizing: border-box;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 16px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 8px;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-row>div {
        flex: 1;
        min-width: calc(50% - 20px);
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
        margin-top: 20px;
    }

    .buttons {
        display: flex;
        gap: 10px;
    }

    .cancel,
    .save {
        padding: 10px 20px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
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

    .images {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #imagePreview {
        max-width: 100px;
        max-height: 70px;
        object-fit: cover;
        display: none;
    }
</style>

<div class="title">
    <h2>Edit Menu Item</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.allrestaurants.list') }}">Restaurants</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('admin.menuofrestaurants.list', ['id' => $restaurant->id]) }}">Menu</a></li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form
            action="{{ route('admin.menuofrestaurants.updateform', ['restaurant_id' => $menuItem->restaurant_id, 'menu_id' => $menuItem->id]) }}"
            method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group {{ $errors->has('category_id') ? 'error' : '' }}">
                    <label for="category_id">Select Category <span style="color: #f44336;">*</span></label>
                    <select name="category_id" id="category_id">
                        <option value="" disabled>Select Category</option>
                        @foreach($categories as $id => $category)
                            <option value="{{ $id }}" {{ $menuItem->category_id == $id ? 'selected' : '' }}>{{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <div class="error-message">{{ $errors->first('category_id') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('item_name') ? 'error' : '' }}">
                    <label for="item_name">Item Name <span style="color: #f44336;">*</span></label>
                    <input type="text" id="item_name" name="item_name" maxlength="50"
                        value="{{ old('item_name', $menuItem->itemname) }}" required>
                    @if ($errors->has('item_name'))
                        <div class="error-message">{{ $errors->first('item_name') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('item_price') ? 'error' : '' }}">
                    <label for="item_price">Item Price <span style="color: #f44336;">*</span></label>
                    <input type="number" id="item_price" name="item_price"
                        value="{{ old('item_price', $menuItem->price) }}" required>
                    @if ($errors->has('item_price'))
                        <div class="error-message">{{ $errors->first('item_price') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('description') ? 'error' : '' }}">
                    <label for="description">Description <span style="color: #f44336;">*</span></label>
                    <textarea id="description" name="description" rows="4" maxlength="255"
                        required>{{ old('description', $menuItem->description) }}</textarea>
                    @if ($errors->has('description'))
                        <div class="error-message">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('image') ? 'error' : '' }}">
                <label for="image">Image <span style="color: #f44336;">*</span></label>
                <div class="images">
                    <input type="file" id="image" name="image">
                    @if ($menuItem->image)
                        <img id="output" src="{{ $menuItem->image }}" style="width: 80px; height:50px;">
                    @else
                        <img id="output" style="width: 80px; height:50px; display: none;">
                    @endif
                    @if ($errors->has('image'))
                        <div class="error-message">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <div class="buttons">
                    <button type="button" class="cancel"
                        onclick="window.location='{{ route('admin.menuofrestaurants.list', ['id' => $restaurant->id]) }}'">Cancel</button>
                    <button type="submit" class="save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var inputImage = document.getElementById('image');
    var outputImage = document.getElementById('output');

    inputImage.addEventListener('change', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            outputImage.src = e.target.result;
            outputImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
    });
</script>
@endsection