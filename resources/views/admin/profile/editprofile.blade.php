@extends('admin/layout/master')

@section('content')
<style>
    .title{
        padding: 10px;
    }
    .images {
        display: flex;
        /* align-items: center; */
        gap: 10px;
    }
    #imagePreview {
        width: 80px;
        height: 50px;
    }
    .btn-primary{
        background-color: #0056b3;
    }
    .btn-primary a{
        text-decoration: none;
        color: #fff;
    }
    .buttons{
        padding: 10px;
    }
    .container{
        display: flex;
        justify-content: center;
      
    }
    form {
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }
    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 18px;
    }
    input{
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    .submit-button{
        padding: 10px 15px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        color: white;
        background-color: #3C5B6F;
        float: right;
    }    
</style>
<div class="title">
    <h2>Edit Profile</h2>
</div>


<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
    </ol>
</div>

@if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
@endif

<div class="buttons">
    <button class="btn btn-primary"><a href="{{route('admin.dashbord')}}">back</a></button>
</div>

<div class="container">
    <form action="{{ route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data" class="edit-profile-form">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <div class="images">
            <input type="file" id="image" name="image">
            @if ($user->image)
                <img src="{{ asset($user->image) }}" alt="Profile Picture" id="imagePreview">
            @endif
            </div>
        </div>


        <button type="submit" class="submit-button">Update Profile</button>
    </form>
</div>
@endsection

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

