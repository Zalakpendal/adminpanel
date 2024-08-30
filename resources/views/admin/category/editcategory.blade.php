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
    .images {
        display: flex;
        gap: 10px;
    }
    #imagePreview {
        width: 80px;
        height: 60px;
        display: none;
    }
</style>

<div class="title">
    <h2>Add Category</h2>
</div>

<div class="homeredirection">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.categories.list')}}">Categorylist</a></li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>

<div class="form">
    <form action="{{ route('admin.categories.updatedata',[$id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="categoryName">Category Name</label>
            <input type="text" id="categoryName" name="categoryName" value="{{ $data->categoryname }}">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <div class="images">
                <input type="file" id="image" name="image">
                @if ($data->image)
                <img id="output" src="{{($data->image) }}" style="width: 80px; height:50px;">
                @else
                <img id="output" style="width: 200px; display: none;">
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

@if(session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error('{{ session('error') }}');
    </script>
@endif
@endsection
