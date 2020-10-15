@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
@endsection

@section('content')
    <div class="h-screen">
        <div class="background" style="background-image: url({{ asset($page->bg) }})"></div>

        @include('partials.navbar')

        <div class="background_content">
            <div class="container mx-auto p-4 flex items-center justify-center flex-col text-white h-full">
                <h2 class="uppercase sm:text-4xl text-xl opacity-75 w-full">{{ $page->subtitle }}</h2>
                <h1 class="uppercase sm:text-5xl text-3xl w-full leading-tight font-bold">{{ $page->title }}</h1>

                <div class="buttons mt-8 w-full">
                    <a href="{{ $page->main_link }}" class="btn rounded-full px-4 shadow">{{ $page->main_link_text }}</a>
                    <a href="{{ $page->sub_link }}" class="btn rounded-full outline px-4 ml-2">{{ $page->sub_link_text }}</a>
                </div>
            </div>
        </div>
    </div>

    <main class="welcome">
        {{-- meet our team --}}
        <div class="bg-white">

            <div class="container mx-auto py-16 p-4">
                <h1 class="pb-16 text-center text-4xl text-gray-800">
                    <span class="c_underline">WHAT WE DO</span>
                </h1>

                <div class="what_we_do">
                    <div data-id="0">
                        <a href="{{ route('events.research') }}">
                            <img draggable="false" src="{{ asset('images/logos/Research.png') }}" alt="Logo">
                            <div class="desc text-center">
                                <h2 class="text-2xl text-gray-800 mt-4">ENDURO RESEARCH</h2>
                                <p class="text-gray-600 mt-2">
                                    Enduro Research is the primary division of our startup. Here, we handle the
                                    conversion of innovative theories into their practical versions.
                                    <span class="underline text-primary text-sm">Learn More.</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div data-id="1">
                        <a href="{{ route('events.prosthesis') }}">
                            <img draggable="false" src="{{ asset('images/logos/ENDURO-PROSTHESIS.png') }}" alt="Logo">
                            <div class="desc text-center">
                                <h2 class="text-2xl text-gray-800 mt-4">ENDURO PROSTHESIS</h2>
                                <p class="text-gray-600 mt-2">
                                    Through our Enduro Prosthesis division, we strive to brighten up the lives of the
                                    differently-abled section of our society. We develop prosthetic implants and
                                    customise vehicles to reach out to them
                                    <span class="underline text-primary text-sm">Learn More.</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div data-id="2" class="active">
                        <img draggable="false" src="{{ asset('images/logos/EVC.png') }}" alt="Logo">
                        <div class="desc text-center">
                            <h2 class="text-2xl text-gray-800 mt-4">ENDURO VEHICLE CHALLENGE (EVC)</h2>
                            <p class="text-gray-600 mt-2">
                                EVC is an eco-friendly venture ,where undergraduates can show their skills and strength in design and manufacturing of E- vehicle which is our future.  EEBC(Enduro Ebike challenge) and ESVC(Enduro Solar vehicle challenge)  are our events.
                                <span class="underline text-primary text-sm">Learn More.</span>
                            </p>
                        </div>
                    </div>
                    <div data-id="3">
                        <img draggable="false" src="{{ asset('images/logos/ENDURO-COMPANION.png') }}" alt="Logo">
                        <div class="desc text-center">
                            <h2 class="text-2xl text-gray-800 mt-4">ENDURO COMPANION</h2>
                            <p class="text-gray-600 mt-2">
                                This is our Non-Governmental Organisation which aims at providing guidance and support to orphans and orphanages. We believe that it's our social responsibility to do so.
                                <span class="underline text-primary text-sm">Learn More.</span>
                            </p>
                        </div>
                    </div>
                    <div data-id="4">
                        <img draggable="false" src="{{ asset('images/logos/ENDURO_FIT.png') }}" alt="Logo">
                        <div class="desc text-center">
                            <h2 class="text-2xl text-gray-800 mt-4">ENDURO FIT</h2>
                            <p class="text-gray-600 mt-2">
                                Enduro Fit is our Sports Club, established to provide training for talented young men and women in a number of different sports.
                                <span class="underline text-primary text-sm">Learn More.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="wwd_desc">
                    <a href="{{ route('events.research') }}">
                        <h2 class="text-2xl text-gray-800 mt-4">ENDURO RESEARCH</h2>
                        <p class="text-gray-600 mt-2">
                            Enduro Research is the primary division of our startup. Here, we handle the conversion of innovative theories into their practical versions.
                            <span class="underline text-primary text-sm">Learn More.</span>
                        </p>
                    </a>
                    <a href="{{ route('events.prosthesis') }}">
                        <h2 class="text-2xl text-gray-800 mt-4">ENDURO PROSTHESIS</h2>
                        <p class="text-gray-600 mt-2">
                            Through our Enduro Prosthesis division, we strive to brighten up the lives of the differently-abled section of our society. We develop prosthetic implants and customize vehicles to reach out to them.
                            <span class="underline text-primary text-sm">Learn More.</span>
                        </p>
                    </a>
                    <div>
                        <h2 class="text-2xl text-gray-800 mt-4">ENDURO VEHICLE CHALLENGE (EVC)</h2>
                        <p class="text-gray-600 mt-2">
                            EVC is an eco-friendly venture ,where undergraduates can show their skills and strength in design and manufacturing of E- vehicle which is our future. EEBC (Enduro Ebike challenge) and ESVC (Enduro Solar vehicle challenge) are our events.
                            <span class="underline text-primary text-sm">Learn More.</span>
                        </p>
                    </div>
                    <div>
                        <h2 class="text-2xl text-gray-800 mt-4">ENDURO COMPANION</h2>
                        <p class="text-gray-600 mt-2">
                            This is our Non-Governmental Organisation which aims at providing guidance and support to orphans and orphanages. We believe that it's our social responsibility to do so.
                            <span class="underline text-primary text-sm">Learn More.</span>
                        </p>
                    </div>
                    <div>
                        <h2 class="text-2xl text-gray-800 mt-4">ENDURO FIT</h2>
                        <p class="text-gray-600 mt-2">
                            Enduro Fit is our Sports Club, established to provide training for talented young men and women in a number of different sports.
                            <span class="underline text-primary text-sm">Learn More.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- what we do --}}
        <div class="bg-gray-200">
            <div class="container mx-auto py-16 p-4">
                <h1 class="pb-16 text-center text-4xl text-gray-800">
                    <span class="c_underline">MEET OUR TEAM</span>
                </h1>

                <div class="testimonial">
                    <div class="left">
                        <img src="{{ asset('icons/chevron-left.svg') }}" alt="Left"/>
                    </div>

                    <div class="content">
                        @foreach ($members as $member)
                            <div class="card">
                                <div class="card_content">
                                    <img src="{{ asset($member->image) }}" alt="{{ $member->name }}"/>
                                    <h2 class="text-2xl sm:text-3xl text-gray-800 mt-4 uppercase">{{ $member->name }}</h2>
                                    <h4 class="m-0 font-semibold uppercase text-primary">{{ $member->position }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="right">
                        <img src="{{ asset('icons/chevron-right.svg') }}" alt="Right"/>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
@endsection

@section('post_content')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).on('ready', function () {
            // meet our team
            $('.testimonial .content').slick({
                prevArrow: '.testimonial .left img',
                nextArrow: '.testimonial .right img',
                adaptiveHeight: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 4000,
            })

            // what we do
            const wwd_desc = $('.wwd_desc').slick({
                accessibility: false,
                arrows: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                waitForAnimate: false,
                swipe: false
            })
            wwd_desc.slick('slickGoTo', 2) // go to the middle

            $('.what_we_do > div').hover(function () {
                let active = $(this).data('id')
                $('.what_we_do .active').removeClass('active')
                $(this).addClass('active')

                wwd_desc.slick('slickGoTo', active)
            })
        })

        // parallax scrolling for welcome image
        window.onload = () =>
            document.addEventListener('scroll', () => parallaxScroll('.background'))
    </script>
@endsection
