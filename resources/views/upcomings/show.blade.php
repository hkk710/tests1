@extends('layouts.app')

@section('title', "{$upcoming->title} | ")

@section('content')
    @include('partials.navbar')

    <div class="mw-800 mx-auto px-4 my-8">
        <h1 class="text-3xl mt-4">{{ $upcoming->title }}</h1>
        <h3 class="text-sm opacity-50">{{ $upcoming->created_at->format('M jS, Y') }}</h3>

        <div class="events-upcoming my-4 rounded" style="background-image: url('{{ asset($upcoming->image) }}')"></div>

        <p class="mt-4">
            {!! $upcoming->description !!}
        </p>

        <div class="mt-4 opacity-75">
            Status: {{ ucfirst($upcoming->status) }}
        </div>
    </div>

    @include('partials.footer')
@endsection
