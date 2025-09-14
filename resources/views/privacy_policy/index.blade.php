@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Privacy Policy</h2>

        <div class="bg-white shadow-md rounded-2xl p-6">
            @if(!empty($policy->content))
                <div class="prose max-w-full">
                    {!! $policy->content !!}
                </div>
            @else
                <p class="text-gray-600">Privacy policy content is not available at the moment.</p>
            @endif
        </div>

    </div>
@endsection
