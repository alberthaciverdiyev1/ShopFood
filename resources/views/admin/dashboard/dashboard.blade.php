@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded shadow">Total Clients: 6389</div>
        <div class="bg-white p-4 rounded shadow">Account Balance: $46,760.89</div>
        <div class="bg-white p-4 rounded shadow">New Sales: 376</div>
        <div class="bg-white p-4 rounded shadow">Pending Contacts: 35</div>
    </div>
@endsection
