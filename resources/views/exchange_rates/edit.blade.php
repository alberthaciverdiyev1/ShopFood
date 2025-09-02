
<!DOCTYPE html>
<html>
<head>
    <title>Edit Rate</title>
</head>
<body>
<h1>Edit Rate for {{ $rate->currency }}</h1>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('exchange-rates.update', $rate->id) }}">
    @csrf
    @method('PUT')
    <label>Rate:</label>
    <input type="text" name="rate" value="{{ $rate->rate }}">
    <button type="submit">Save</button>
</form>

<a href="{{ route('exchange-rates.index') }}">Back</a>
</body>
</html>
