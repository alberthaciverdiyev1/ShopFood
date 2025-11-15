@extends('layouts.app')

@section('content')
    @include('components.hero')
    @include('components.catalog')
    @include('components.menu-banner')
<x-suggestions :products="$products" :tags="$tags" />
{{--<x-advertisement-product :products="$products"/>--}}
{{--<x-suggestions :products="$products" />--}}

@endsection

@section('styles')
    @vite('resources/css/home.css')
    @vite('resources/css/app.css')
@endsection

@section('scripts')
    @vite('resources/js/home.js')

@endsection
