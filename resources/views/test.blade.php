<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing</title>
</head>
<body>
    <div class="details">
        @if(auth()->guard('admin')->check())
        
          {{auth()->guard('admin')->user()->name}}
            <a href="{{route('admin.logout')}}">Logout</a>
        @endif
    </div>
</body>
</html>