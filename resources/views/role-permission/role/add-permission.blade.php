@extends('admin/layout/master')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap');

    body {
        background-color: #f4f6f9;
        font-family: 'Roboto', sans-serif;
    }

    .title h2 {
        padding: 10px;
        font-size: 24px;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 400; /* Normal weight */
    }

    .actions {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 20px;
        margin-left: 20px;
    }

    .actions .btn {
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        transition: background-color 0.2s;
        font-size: 14px;
    }

    .actions .btn:hover {
        background-color: #0056b3;
    }

    .permission-card {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 10px;
        background-color: #fff;
        transition: border-color 0.2s;
    }

    .permission-card:hover {
        border-color: #007bff;
    }

    .permission-card input[type="checkbox"] {
        margin-right: 8px;
        cursor: pointer;
    }

    .permission-label {
        margin-bottom: 15px;
        font-size: 18px;
        color: #3C3D37;
        font-weight: 400; /* Normal weight */
    }

    .select-all-container {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .select-all-container input[type="checkbox"] {
        margin-right: 10px;
        transform: scale(1.2);
        cursor: pointer;
    }

    .submit-button {
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        color: white;
        background-color: #28a745;
        transition: background-color 0.2s;
    }

    .submit-button:hover {
        background-color: #218838;
    }

    .card-body {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .alert {
        margin: 20px 0;
        padding: 10px;
        border-radius: 4px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }           
</style>

@if (session('status'))
    <div class="alert">{{ session('status') }}</div>
@endif

<div class="title">
    <h2>Role: {{ $role->name }}</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashbord') }}">Home</a></li>
    </ol>
</div>

<div class="actions">
    <button class="btn"><a href="{{ url('role') }}" style="color: white; text-decoration: none;">Back</a></button>
</div>

<div class="card-body">
    <form action="{{ url('role/' . $role->id . '/give-permissions') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-2">
            @error('permission')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="permission-label">List Of Permissions</label>

            <div class="select-all-container">
                <label>
                    <input type="checkbox" id="selectAll" /> Select All
                </label>
            </div>

            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-3 mb-3">
                        <div class="permission-card">
                            <label>
                                <input  
                                    type="checkbox"
                                    name="permission[]" 
                                    value="{{ $permission->name }}" 
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                    class="permission-checkbox"
                                />
                                {{ $permission->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="submit-button">Update</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#selectAll').change(function() {
            $('.permission-checkbox').prop('checked', this.checked);
        });

        $('.permission-checkbox').change(function() {
            $('#selectAll').prop('checked', $('.permission-checkbox:checked').length === $('.permission-checkbox').length);
        });
    });
</script>
@endsection
