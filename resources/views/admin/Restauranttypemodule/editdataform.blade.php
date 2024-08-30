@extends('admin/layout/master')
@section('content')
<style>
     .title h2 {
        padding: 10px;
    }
    .form{
        width: 1050px;
        margin: 20px;
        padding: 50px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 20px;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        /* border-radius: 5px; */
    }
    .form-actions {
        display: flex;
        float: right;      
    }

    .buttons{
        float: right;
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }
    .cancel,.save{
        padding: 10px 15px; 
        cursor: pointer;
        border: none;
        background-color: #768c9a;
        color: white;
    }
    .cancel:hover{
        background-color: #1e2d37;  
    }
    .save:hover{
        background-color: #1e2d37;
    }
    .buttons a{
        color:white;
    }
    .buttons a:hover{
        color: white;
    }
</style>
<div class="title">
    <h2>Restaurant Type</h2>
</div>
        <div class="homeredirection">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashbord')}}">Home</a></li> 
            <li class="breadcrumb-item"><a href="{{route('admin.restaurant.list')}}">Restaurant type</a></li> 
            </ol>
            
        </div>

<div class="form">
    <form action="{{route('admin.restaurant.updatedata',[$id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="edittitle">
        <h3>Edit Form</h3>
    </div>
        <div class="form-group">
            <label for="restaurant-type">Restaurant Type</label>
            <input type="text" id="restaurant-type" name="restaurant_type" value="{{$data->restauranttype}}" required>
            <div class="buttons">
            <button type="button" class="cancel"><a href="{{route('admin.restaurant.list')}}">Cancel</a></button>
            <button type="submit" class="save" value="Update">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection