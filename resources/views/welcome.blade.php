<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Shop Food</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

<div class="container">
    <div class="card">
        <div class="logo">
            <img src="{{asset('images/logo.png')}}" alt="Shop Food Logo">
        </div>
        <h1>@lang('Welcome')</h1>
        <a href="{{route('web:register')}}" class="btn">@lang("Register")</a>
        <a href="{{route('login')}}" class="btn">@lang("Login")</a>
    </div>
</div>

</body>
</html>
