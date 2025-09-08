<?php
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>User Details</h1>

        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Discount:</strong> {{ $user->discount_percentage }}%</p>

        <form action="{{ route('admin.users.applyDiscount', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">
                Apply {{ $user->discount_percentage }}% Discount
            </button>
        </form>
    </div>
@endsection
