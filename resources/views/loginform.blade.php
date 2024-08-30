<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login Form Admin</title>
    <style>
        body {
            background-color: #D1D8C5;
            color: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 600px;
            /* margin: 0; */
        }
        .login-container {
            background-color: #F7F9F2;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        .login-container img {
            width: 120px;
            height: 120px;
            margin-bottom: 10px;
            margin-top: 0;
        }
        .login-container h2 {
            margin-top: 5px;
            margin-bottom: 15px;
            color: #01204E;
        }
        .input-container {
            display: flex;
            width: 100%;
            margin-bottom: 10px;
            align-items: center;
            border-bottom: 1px solid gray;
            /* border-radius: 5px; */
        }

        .icon {
            padding: 10px;
            color: black;
            min-width: 50px;
            text-align: center;
            /* border-top-left-radius: 3px; */
            /* border-bottom-left-radius: 3px; */
        }
        .input-field {
            width: 100%;
            padding: 10px;
            outline: none;
            border: none;
            font-size: 16px;
            background-color: #F7F9F2;
        }
        .input-field::placeholder {
            color: #939185;
            font-size: 15px;
        }
        .passwordfield{
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #3C5B6F;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #153448;
        }
        .forusername{
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="https://content.jdmagicbox.com/comp/navi-mumbai/f1/022pxx22.xx22.180215143800.m6f1/catalogue/food-junction-kopar-khairane-navi-mumbai-home-delivery-restaurants-8tnfw.jpg" alt="Restaurant Logo">
        <h2>Login</h2>
        <form action="{{route('login')}}" method="post">
        @csrf
            <div class="forusername">
            <div class="input-container">
                <i class="fa fa-user icon" style="font-size: 22px"></i>
                <input class="input-field" type="text" placeholder="Username" name="email">
            </div>
            @error('email') <font color="red">{{$message}}</font>@enderror
            </div>

            <div class="passwordfield">
            <div class="input-container">
                <i class="fa fa-key icon" style="font-size: 20px"></i>
                <input class="input-field" type="password" placeholder="Password" name="password" id="password">
            </div>
            @error('password') <font color="red">{{$message}}</font>@enderror
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>