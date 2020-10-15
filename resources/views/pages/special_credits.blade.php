@extends('layouts.app')

@section('title', 'Special Credits | ')

@section('content')
    @include('partials.navbar')

    <div class="mw-900 mx-auto px-4 py-16">
        <h1 class="uppercase c_underline text-3xl">
            <span>Logo Designing, Teaser and Editography</span>
        </h1>

        <div class="mt-16 flex">
            <div>
                <img src="{{ asset('images/credits/orfik_studios.jpg') }}" width="200" alt="ORFIK STUDIOS" class="rounded-full bg-white shadow" />
            </div>

            <div class="flex-1 flex justify-center flex-col pl-4">
                <h2 class="text-2xl font-bold">ORFIK STUDIOS</h2>
                <div class="flex">
                    <a rel="nofollow" target="_blank" href="https://instagram.com/orfik.studios?igshid=kifkh5giyyxa">
                        <img src="{{ asset('icons/instagram.svg') }}" alt="Instagram" width="18" height="18" />
                    </a>
                </div>
            </div>
        </div>

        <h1 class="uppercase c_underline text-3xl mt-16">
            <span>Content Writer</span>
        </h1>

        <div class="mt-16 flex">
            <div>
                <img src="{{ asset('images/credits/A_Hopeless_Optimist.png') }}" width="200" alt="A Hopeless Optimist" class="rounded-full bg-white shadow" />
            </div>

            <div class="flex-1 flex justify-center flex-col pl-4">
                <h2 class="text-2xl font-bold">A Hopeless Optimist</h2>
                <div class="flex">
                    <a rel="nofollow" target="_blank" href="https://ahopelessoptimist.art.blog/">
                        <img src="{{ asset('icons/globe.svg') }}" alt="Website" width="18" height="18" />
                    </a>
                </div>
            </div>
        </div>

        <h1 class="uppercase c_underline text-3xl mt-16">
            <span>BGM</span>
        </h1>

        <div class="mt-16 flex">
            <div>
                <img src="{{ asset('images/credits/Adarsh_Production.png') }}" width="200" alt="Adarsh Production" class="rounded-full bg-white shadow" />
            </div>

            <div class="flex-1 flex justify-center flex-col pl-4">
                <h2 class="text-2xl font-bold">Adarsh Production</h2>
                <div class="flex">
                    <a rel="nofollow" target="_blank" href="https://www.instagram.com/adarsh_as06">
                        <img src="{{ asset('icons/instagram.svg') }}" alt="Instagram" width="18" height="18" />
                    </a>
                </div>
            </div>
        </div>

        <h1 class="uppercase c_underline text-3xl mt-16">
            <span>Logo Animation</span>
        </h1>

        <div class="mt-16 flex">
            <div>
                <img src="{{ asset('images/credits/Mewt_media.png') }}" width="200" alt="Mewt Media" class="rounded-full bg-white shadow" />
            </div>

            <div class="flex-1 flex justify-center flex-col pl-4">
                <h2 class="text-2xl font-bold">Mewt Media</h2>
                <div class="flex">
                    <a rel="nofollow" target="_blank" href="https://www.instagram.com/a_mewt">
                        <img src="{{ asset('icons/instagram.svg') }}" alt="Instagram" width="18" height="18" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection
