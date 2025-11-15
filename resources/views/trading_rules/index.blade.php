@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Trading Rules</h2>

        <div class="bg-white shadow-md rounded-2xl p-6">
            @if(!empty($rule->content))
                <div class="prose max-w-full">
                    {!! $rule->content !!}
                </div>
            @else
                <p class="text-gray-600">Trading Rules content is not available at the moment.</p>
            @endif
        </div>

    </div>
@endsection
