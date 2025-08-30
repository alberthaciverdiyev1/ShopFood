<!DOCTYPE html>
<html>
<head>
    <title>Exchange Rates</title>
</head>
<body>
<h1>Exchange Rates</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>Currency</th>
        <th>Rate</th>
        <th>Action</th>
    </tr>
    @foreach($rates as $rate)
        <tr>
            <td>{{ $rate->currency }}</td>
            <td>{{ $rate->rate }}</td>
            <td><a href="{{ route('exchange-rates.edit', $rate->id) }}">Edit</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
