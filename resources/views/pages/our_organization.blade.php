@extends('layouts.app')

@section('title', 'Our Organization | ')

@section('content')
    @include('partials.navbar')

    <div class="mw-900 mx-auto py-16 px-4">
        <h1 class="uppercase c_underline text-3xl">
            <span>Our Organization</span>
        </h1>

        @foreach ($members as $member)
            <div class="mt-16 bg-white p-4 rounded shadow-lg">
                <div class="our_organization">
                    <div class="flex justify-center">
                        <img src="{{ asset($member->image) }}" alt="{{ $member->name }}"
                             width="200" class="rounded-full"/>
                    </div>

                    <div class="flex items-center oo_list pl-8 pt-4 sm:pt-0">
                        {!! $member->our_organization_description !!}
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <h2 class="text-xl sm:text-2xl text-gray-800 mt-4 uppercase">{{ $member->name }}</h2>
                        <h4 class="m-0 font-semibold uppercase text-primary">{{ $member->qualification }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('partials.footer')
@endsection
