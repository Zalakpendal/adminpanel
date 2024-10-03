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
    .form-group select {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 8px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"] {
        height: 40px;
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
    .form-group.error select {
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

    .required {
        color: #f44336;
        /* Red color for required fields */
    }

    @media (max-width: 768px) {
        .form-row>div {
            min-width: 100%;
        }
    }
</style>

<div class="title">
    <h2>Create User</h2>
</div>
<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form action="{{ url('users') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group {{ $errors->has('restaurants') ? 'error' : '' }}">
                    <label for="restaurants">Restaurant</label>
                    <select name="restaurants" class="form-control">
                        <option value="" selected disabled>Select Restaurant</option>
                        @foreach ($restaurants as $id => $restaurantsname)
                            <option value="{{ $id }}">{{ $restaurantsname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                    <label for="name">User Name <span class="required">*</span></label>
                    <input type="text" name="name" maxlength="50" class="form-control" placeholder="Enter user name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="error-message">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="text" name="email" class="form-control" maxlength="100" placeholder="Enter email address"  value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('password') ? 'error' : '' }}">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                    @if ($errors->has('password'))
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group {{ $errors->has('roles') ? 'error' : '' }}">
                    <label for="roles">Role<span class="required">*</span></label>
                    <select name="roles[]" class="form-control">
                        <option value=""selected disabled>Select Role</option>
                        @foreach ($roles as $id => $name)
                            <!-- <option value="{{ $id }}">{{ $name }}</option> -->
                            <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <div class="error-message">{{ $errors->first('roles') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <div class="buttons">
                    <button type="button" class="cancel"><a href="{{ url('users') }}"
                            style="color: white; text-decoration: none;">Cancel</a></button>
                    <button type="submit" class="save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection