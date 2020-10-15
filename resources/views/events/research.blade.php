@extends('layouts.app')

@section('title', 'Enduro Research | ')

@section('content')
    <div class="events-wrapper">
        <div class="background research-background events-background">
            @include('partials.navbar')
        </div>
    </div>

    <div class="bg-white">
        <div class="mw-900 mx-auto py-16 px-8">
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/logos/Research.png') }}" alt="Enduro Research" class="bg-white rounded-full" width="100" />
                <div class="mt-2 text-2xl">Enduro Research</div>
            </div>

            <div class="uppercase text-2xl text-center mt-4">
                Be a part of history by <span class="text-primary">transforming your ideas into reality</span> with us
            </div>

            <div class="mt-4 flex justify-center">
                <a href="https://forms.gle/zcTuSMFfsiF2aeXd7" class="btn">Register</a>
            </div>
        </div>
    </div>

    <div class="bg-gray-200 md:grid grid-cols-2">
        <div class="research_2"></div>

        <div class="bg-primary-fade text-white">
            <div class="py-8 md:px-16 px-8 container mx-auto">
                <h1 class="c_underline_white uppercase text-3xl mb-16">
                    <span>What we do</span>
                </h1>

                <p>
                    If you think technology can solve your crisis, share with us your story. Also, feel free to bring in innovative ideas and see them transform into working practical models. We also choose and execute projects in public interest.
                </p>
            </div>
        </div>
    </div>

    @if ($upcomings->count() > 0)
        <div class="container mx-auto py-16 px-8">
            <h1 class="c_underline text-3xl uppercase"><span>Upcoming Projects</span></h1>

            <div class="md:grid {{ $upcomings->count() > 1 ? 'grid-auto-2' : '' }} mt-16 gap-8">
                @foreach ($upcomings as $upcoming)
                    <div class="bg-white rounded {{ $upcomings->count() > 1 ? '' : 'md:grid' }} grid-cols-2 shadow overflow-hidden {{ $loop->first ? '' : 'md:mt-0 mt-8' }}">
                        <div class="events-upcoming" style="background-image: url('{{ asset($upcoming->image) }}')"></div>

                        <div class="py-8 md:px-16 px-8 container mx-auto">
                            <h1 class="text-2xl">
                                {{ $upcoming->title }}
                            </h1>

                            <p class="text-gray-800">
                                <a href="{{ route('upcoming.show', $upcoming->id) }}" class="underline text-primary text-sm">Learn
                                    More.</a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mt-8 shadow rounded" role="alert">
                <p>Until the ongoing Covid-19 crisis comes to an end, we are only taking up projects related to the same. Thank you for your patience.</p>
            </div>
        </div>
    @endif

    @if ($projects->count() > 0)
        <div class="bg-gray-200">
            <div class="container mx-auto py-16 px-8">
                <h1 class="c_underline text-3xl uppercase"><span>Our Projects</span></h1>

                <div class="md:grid {{ $projects->count() > 1 ? 'grid-auto-2' : '' }} mt-16 gap-8">
                    @foreach ($projects as $project)
                        <div class="bg-white rounded {{ $projects->count() > 1 ? '' : 'md:grid' }} grid-cols-2 shadow overflow-hidden {{ $loop->first ? '' : 'md:mt-0 mt-8' }}">
                            <div class="events-upcoming"
                                 style="background-image: url('{{ asset($project->image) }}')"></div>

                            <div class="py-8 md:px-16 px-8 container mx-auto">
                                <h1 class="text-2xl">
                                    {{ $project->title }}
                                </h1>

                                <p class="text-gray-800">
                                    <a href="{{ route('upcoming.show', $project->id) }}"
                                       class="underline text-primary text-sm">Learn More.</a>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end mt-4">
                    <a href="{{ route('upcoming.index', 'research') }}" class="underline text-blue-600">view all</a>
                </div>
            </div>
        </div>
    @endif

    @include('partials.footer')
@endsection

@section('post_content')
    <script>
        window.onload = () =>
            document.addEventListener('scroll', () => parallaxScroll('.research-background'))
    </script>
@endsection
