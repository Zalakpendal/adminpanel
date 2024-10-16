@extends('admin/layout/master')

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
    <h2>Add Category</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.list') }}">Category List</a></li>
        <li class="breadcrumb-item">Add</li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form action="{{ route('admin.categories.insert') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('categoryName') ? 'error' : '' }}">
                <label for="categoryName">Category Name <span style="color: #f44336;">*</span></label>
                <input type="text" id="categoryName" name="categoryName" maxlength="50" placeholder="Enter category name" value="{{ old('categoryName') }}">
                @if ($errors->has('categoryName'))
                    <div class="error-message">{{ $errors->first('categoryName') }}</div>
                @elseif($errors->has('categoryName'))
                <div class="error-message" style="color: red;">
                        {{ $errors->first('categoryName') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ $errors->has('image') ? 'error' : '' }}">
                <label for="image">Image <span style="color: #f44336;">*</span></label>
                <div class="images">
                    <input type="file" id="image" name="image">
                    <img id="imagePreview" src="#" alt="Preview">
                    @if ($errors->has('image'))
                        <div class="error-message">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <div class="buttons">
                    <button type="button" class="cancel"><a href="{{ route('admin.categories.list') }}" style="color: white; text-decoration: none;">Cancel</a></button>
                    <button type="submit" class="save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#image').change(function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                $('#imagePreview').attr('src', reader.result).show();
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    });
</script>

@endsection
