<?php
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit User</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="discount_percentage" class="form-label">Discount (%)</label>
                <input type="number" name="discount_percentage" id="discount_percentage"
                       value="{{ old('discount_percentage', $user->discount_percentage) }}"
                       min="0" max="100"
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection
