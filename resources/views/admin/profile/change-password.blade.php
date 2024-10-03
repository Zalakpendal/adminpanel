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

    .form-group input {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        height: 40px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row > div {
        flex: 1;
    }

    .form-group.error input {
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
    }
</style>

<div class="title">
    <h2>Change Password</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>

<div class="form-container">
    <div class="form">
        <form action="{{ route('admin.changePassword.submit') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group {{ $errors->has('current_password') ? 'error' : '' }}">
                    <label for="current_password">Current Password <span class="required">*</span></label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                    @if ($errors->has('current_password'))
                        <div class="error-message">{{ $errors->first('current_password') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('new_password') ? 'error' : '' }}">
                    <label for="new_password">New Password <span class="required">*</span></label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                    @if ($errors->has('new_password'))
                        <div class="error-message">{{ $errors->first('new_password') }}</div>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('new_password_confirmation') ? 'error' : '' }}">
                    <label for="new_password_confirmation">Confirm New Password <span class="required">*</span></label>
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password" required>
                    @if ($errors->has('new_password_confirmation'))
                        <div class="error-message">{{ $errors->first('new_password_confirmation') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <div class="buttons">
                    <button type="button" class="cancel"><a href="{{ url('users') }}" style="color: white; text-decoration: none;">Cancel</a></button>
                    <button type="submit" class="save">Change Password</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
