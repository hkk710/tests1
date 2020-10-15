<footer class="bg-gray-800 shadow-lg py-8 text-white">
    <div class="flex container mx-auto px-4">
        <div class="flex-1">
            <div class="uppercase font-bold">About Us</div>
            <ul class="mt-3">
                <li><a href="{{ route('our_organization') }}">Our Organization</a></li>
                <li class="mt-1"><a href="{{ route('special_credits') }}">Special Credits</a></li>
            </ul>
        </div>
        <div class="flex-1">
            <div class="uppercase font-bold">Contact Us</div>
            <ul class="mt-3">
                <li><a href="{{ route('contactus') }}">Enduro-I</a></li>
                <li class="mt-1">
                    <ul class="flex">
                        <li>
                            <a href="https://facebook.com/enduro.5s" target="_blank">
                                <img src="{{ asset('icons/facebook_white.svg') }}" alt="Facebook" width="18" height="18" />
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/i_enduro" target="_blank">
                                <img src="{{ asset('icons/twitter_white.svg') }}" alt="Twitter" width="18" height="18" />
                            </a>
                        </li>
                        <li class="ml-2">
                            <a href="https://instagram.com/enduro_i_5s" target="_blank">
                                <img src="{{ asset('icons/instagram_white.svg') }}" alt="Instagram" width="18" height="18" />
                            </a>
                        </li>
                        <li class="ml-2">
                            <a href="https://linkedin.com/in/enduro-innovative-9553a41b1" target="_blank">
                                <img src="{{ asset('icons/linkedin_white.svg') }}" alt="Linkedin" width="18" height="18" />
                            </a>
                        </li>
                        <li class="ml-2">
                            <a href="https://youtube.com/channel/UCWorBt10v8tRAiVKnMUjonA?view_as=subscriber" target="_blank">
                                <img src="{{ asset('icons/youtube_white.svg') }}" alt="Youtube" width="18" height="18" />
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</footer>

<footer class="bg-gray-900 py-4 text-white">
    <div class="container mx-auto px-4">
        <div class="uppercase flex justify-center items-center">
            <span class="text-sm">Inspired and supported by</span>
            <a href="https://www.amrita.edu" class="ml-2">
                <img src="{{ asset('images/amrita.png') }}" alt="Amrita Vishwa VidyaPeetham" width="100" />
            </a>
        </div>

        <div class="text-sm text-center">
            Copyright &copy; {{ date('Y') }} | <a href="http://recapdigitalsolutions.in/">Recap Digital Solutions</a> | All rights reserved
        </div>
    </div>
</footer>
