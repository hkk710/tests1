@extends('layouts.app')

@section('title', 'Overview | ')

@section('content')
    @include('partials.navbar')

    <div class="py-16 mx-auto mw-900 px-8">
        <h1 class="c_underline mb-12 text-3xl uppercase">
            <span>Enduro Innovative</span>
        </h1>

        <div>
            <p>Enduro Innovative is a startup launched in 2020 by a group of passionate engineering students of Amrita Institute. The primary purpose of this startup is to conduct research on innovative eco-friendly technology and use their practical applications to design products and provide services. We have structured our company into five divisions so as to equally concentrate on growing ourselves as a tech-startup and also as a group of socially responsible human beings. You are welcome to look up our five main divisions on our Home page.</p>
            <p class="mt-4">This endeavor has been greatly inspired and supported from the start by Amrita Institute of Technology, our alma mater. Team Enduro is held together by the shared enthusiasm towards our subject and a strong motivation for hardwork and persistence.</p>
        </div>
    </div>

    <div class="md:grid grid-cols-2">
        <div class="md:block hidden mission"></div>

        <div class="bg-primary-fade text-white py-8 md:px-16 px-8">
            <h1 class="c_underline_white mb-12 text-3xl uppercase">
                <span>Our Mission</span>
            </h1>

            <div>
                <p>We at Enduro Innovative consider it our mission to contribute to the scientific and technological community by pushing ourselves to use the full potential of our knowledge and skills. We are committed to keep on testing our limits and to be consistent in our efforts to come up with innovative concepts.</p>
                <p class="mt-4">We also consider it our duty and obligation to give back to the community. Our resources and skills are handled in a way that they will provide a helping hand to the society, thus making social service a part of our mission.</p>
            </div>
        </div>
    </div>

    <div class="md:grid grid-cols-2">
        <div class="bg-primary-fade text-white py-8 md:px-16 px-8">
            <h1 class="c_underline_white mb-12 text-3xl uppercase">
                <span>Our Vision</span>
            </h1>

            <div>
                <p>We are living in an age where the face of our world is being rapidly changed by the incredible pace at which technology is growing. In such a time it is of imperative importance that it should grow in the right direction. We make it our vision to grow ourselves as a socially responsible company, with ethics and innovation at heart, using the technology in our hands for the best of mankind. We dream of inspiring future startups one day, guiding them in the right direction and instilling in them the right values.</p>
            </div>
        </div>

        <div class="md:block hidden vision"></div>
    </div>

    <div class="bg-pattern">
        <div class="py-16 mx-auto mw-900 px-8">
            <h1 class="c_underline mb-12 text-3xl uppercase">
                <span>A word from our CEO</span>
            </h1>

            <div class="flex flex-col">
                <p class="quotes">The fate of our future lies in the hands of innovation. It is unquestionable that in the course of time we will have to face unexpected crises which will threaten our own existence. Thus modifications and innovations are vital for the survival of our world as it is now. We usually associate these terms with technology, but it applies to every single sphere of our life. I believe that innovation is the solution to any problem, and I consider hard work and consistency as the inseparable companions of innovation. Thus when endurance and innovation goes hand in hand, with concern for environment and sustainability in mind, we have before us the formula for a perfect world.</p>

                <div class="opacity-75 text-right text-xl mt-2">
                    - Jithu Krishna A J
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection
