<nav class="navbar bg-white">
    <section class="top" :class="{ sidebar }">
        <div class="container mx-auto flex px-4">
            <div class="social">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/enduro.5s" target="_blank">
                            <img src="{{ asset('icons/facebook.svg') }}" alt="Facebook" />
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/i_enduro" target="_blank">
                            <img src="{{ asset('icons/twitter.svg') }}" alt="Twitter" />
                        </a>
                    </li>
                    <li>
                        <a href="https://instagram.com/enduro_i_5s" target="_blank">
                            <img src="{{ asset('icons/instagram.svg') }}" alt="Instagram" />
                        </a>
                    </li>
                    <li>
                        <a href="https://linkedin.com/in/enduro-innovative-9553a41b1" target="_blank">
                            <img src="{{ asset('icons/linkedin.svg') }}" alt="Linkedin" />
                        </a>
                    </li>
                    <li>
                        <a href="https://youtube.com/channel/UCWorBt10v8tRAiVKnMUjonA?view_as=subscriber" target="_blank">
                            <img src="{{ asset('icons/youtube.svg') }}" alt="Youtube" />
                        </a>
                    </li>
                </ul>
            </div>

            <div class="links uppercase">
                <ul>
                    <li>
                        <a href="{{ route('our_organization') }}">OUR ORGANZIATION</a>
                    </li>
                    <li>
                        <a href="{{ route('overview') }}">OVERVIEW</a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard.index') }}">Hi {{ Auth::user()->name }}!</a>
                        </li>
                        <li>
                            <a href="#" @click.prevent="$refs['logout'].submit()">Logout</a>

                            <form action="{{ route('logout') }}" method="post" ref="logout">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </section>


    <div class="main shadow-lg">
        <div class="container mx-auto p-4">
            <div class="logo">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" /></a>
            </div>

            <div class="hamburger" :class="{ active: sidebar }" @click="sidebar = !sidebar">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
</nav>
