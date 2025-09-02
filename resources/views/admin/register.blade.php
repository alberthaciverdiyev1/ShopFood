
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email daxil edin" required>
        @error('email')
            <p style="color: red">{{ $message }}</p>
        @enderror
        <button type="submit">Submit</button>
    </form>
</body>
</html>
