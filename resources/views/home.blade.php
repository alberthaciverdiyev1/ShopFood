@extends('layouts.app')

@section('content')
    <p>salam</p>

    @include('components.hero')
@endsection

@section('styles')
    @vite('resources/css/home.css')
@endsection

@section('scripts')
    @vite('resources/js/home.js')
@endsection
