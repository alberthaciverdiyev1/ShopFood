@extends('layouts.app')

@section('content')

    @include('components.hero')
@endsection

@section('styles')
    @vite('resources/css/home.css')
    @vite('resources/css/app.css')

@endsection

@section('scripts')
    @vite('resources/js/home.js')
@endsection
