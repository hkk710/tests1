@extends('layouts.app')

@section('title', "Our Projects | ")

@section('content')
    @include('partials.navbar')

    <div class="container mx-auto px-4 my-16">
        <h1 class="c_underline text-3xl uppercase mb-16"><span>Our Projects</span></h1>

        <form class="flex justify-between mb-8">
            <input type="hidden" name="page" value="{{ request('page') ?? 1 }}"/>

            <div class="flex">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                       placeholder="Search by title..."/>

                <select name="month" class="form-control ml-4">
                    <option value="">Search by month...</option>
                    <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>January</option>
                    <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>February</option>
                    <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>March</option>
                    <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                    <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>May</option>
                    <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>June</option>
                    <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>July</option>
                    <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>August</option>
                    <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>October</option>
                    <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>December</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn green">Search</button>
            </div>
        </form>

        <div class="lg:grid grid-auto-3 gap-8 mb-4">
            @forelse ($upcomings as $upcoming)
                <div class="bg-white rounded shadow overflow-hidden {{ $loop->first ? '' : 'lg:mt-0 mt-8' }}">
                    <div class="events-upcoming"
                         style="background-image: url('{{ asset($upcoming->image) }}')"></div>

                    <div class="py-8 md:px-16 px-8 container mx-auto">
                        <h1 class="text-2xl">{{ $upcoming->title }}</h1>
                        <h3 class="text-sm opacity-50">{{ $upcoming->created_at->format('M jS, Y') }}</h3>

                        <p class="text-gray-800 mt-2">
                            <a href="{{ route('upcoming.show', $upcoming->id) }}"
                               class="underline text-primary text-sm">Learn More.</a>
                        </p>
                    </div>
                </div>
            @empty
                <div>
                    Nothing in the archive.
                </div>
            @endforelse
        </div>

        {{ $upcomings->appends(request()->query())->links() }}
    </div>

    @include('partials.footer')
@endsection
