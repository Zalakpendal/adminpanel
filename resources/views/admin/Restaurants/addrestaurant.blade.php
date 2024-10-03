@extends('admin/layout/master')
@section('content')
<style>
    /* Add styles here */
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

    .form-group input[type="text"],
    .form-group input[type="email"] {
        height: 40px;
    }

    .form-group textarea {
        height: auto;
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
    <h2>Add Restaurant</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.allrestaurants.list') }}">All Restaurant</a></li>
        <li class="breadcrumb-item">Add</li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form action="{{ route('admin.allrestaurants.insert') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group {{ $errors->has('restaurantName') ? 'error' : '' }}">
                    <label for="restaurantName">Restaurant Name <span style="color: #f44336;">*</span></label>
                    <input type="text" id="restaurantName" name="restaurantName" maxlength="100" placeholder="Enter restaurant name"
                        value="{{ old('restaurantName') }}">
                    @if ($errors->has('restaurantName'))
                        <div class="error-message">{{ $errors->first('restaurantName') }}</div>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
                    <label for="email">Email <span style="color: #f44336;">*</span></label>
                    <input type="email" id="email" name="email" maxlength="100" placeholder="Enter email address"
                        value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('restaurantType') ? 'error' : '' }}">
                    <label for="restaurantType">Restaurant Type <span style="color: #f44336;">*</span></label>
                    <select id="restaurantType" name="restaurantType">
                        <option value="" disabled selected>Select Type</option>
                        @foreach($restaurantTypes as $id => $type)
                            <option value="{{ $id }}" {{ old('restaurantType') == $id ? 'selected' : '' }}>{{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('restaurantType'))
                        <div class="error-message">{{ $errors->first('restaurantType') }}</div>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('phoneNumber') ? 'error' : '' }}">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" maxlength="13" pattern="\d{5} \d{5}"
                        placeholder="98765 43210" value="{{ old('phoneNumber') }}">
                    @if ($errors->has('phoneNumber'))
                        <div class="error-message">{{ $errors->first('phoneNumber') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('address') ? 'error' : '' }}">
                    <label for="address">Address <span style="color: #f44336;">*</span></label>
                    <input type="text" id="address" name="address" maxlength="255" placeholder="Enter restaurant address"
                        value="{{ old('address') }}">
                    @if ($errors->has('address'))
                        <div class="error-message">{{ $errors->first('address') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('description') ? 'error' : '' }}">
                    <label for="description">Description <span style="color: #f44336;">*</span></label>
                    <textarea id="description" name="description" rows="4" maxlength="255"
                        placeholder="Enter restaurant description">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class="error-message">{{ $errors->first('description') }}</div>
                    @endif
                </div>
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
                    <button type="button" class="cancel"><a href="{{ route('admin.allrestaurants.list') }}"
                            style="color: white; text-decoration: none;">Cancel</a></button>
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
