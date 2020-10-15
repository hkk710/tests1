<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description"
          content="Enduro Innovative is a startup launched in 2020 by a group of passionate engineering students of Amrita Institute. The primary purpose of this startup is to conduct research on innovative eco-friendly technology and use their practical applications to design products and provide services."/>
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title'){{ config('app.name', 'Enduro') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    @yield('styles')
</head>
<body>
<div id="app" class="dashboard">
    <alert-component message="{{ Session::get('success') }}"></alert-component>

    <div class="backdrop" :class="{ active: dashboard }" @click="dashboard = false"></div>

    <aside class="dashboard-sidebar bg-white shadow-lg" :class="{ active: dashboard }">
        <ul>
            @can('manage_users')
                <li class="{{ request()->segment(2) === 'user' ? 'active' : '' }}"
                    @click="url('{{ route('dashboard.user.index') }}')">Manage Users
                </li>
            @endcan
            @can('manage_roles')
                <li class="{{ request()->segment(2) === 'role' ? 'active' : '' }}"
                    @click="url('{{ route('dashboard.role.index') }}')">Manage Roles
                </li>
            @endcan
            @can('manage_files')
                <li class="{{ request()->segment(2) === 'member' ? 'active' : '' }}"
                    @click="url('{{ route('dashboard.member.index') }}')">Manage Members
                </li>
            @endcan
            @can('manage_tags')
                <li class="{{ request()->segment(2) === 'tag' ? 'active' : '' }}"
                    @click="url('{{ route('dashboard.tag.index') }}')">Manage Tags
                </li>
            @endcan
            <li class="{{ request()->segment(2) === 'file' ? 'active' : '' }}"
                @click="url('{{ route('dashboard.file.index') }}')">Manage Files
            </li>
            <li class="{{ request()->segment(2) === 'upcoming' ? 'active' : '' }}"
                @click="url('{{ route('dashboard.upcoming.index') }}')">Upcoming projects
            </li>
            <li>News</li>
            <li class="dropdown">Edit Page</li>
            <li class="dropdown-content">
                <ul>
                    <li class="{{ request()->segment(3) === 'home' ? 'active' : '' }}"
                        @click="url('{{ route('dashboard.pages.home') }}')">Home Page
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    <main class="dashboard-main" :class="{ active: dashboard }">
        <nav class="bg-gray-800 text-white shadow-lg">
            <div class="container mx-auto p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="hamburger" @click="dashboard = !dashboard">
                        <span></span><span></span><span></span>
                    </div>

                    <h1 class="ml-8 uppercase text-xl md:text-2xl">
                        Enduro Innovative Dashboard
                    </h1>
                </div>

                <div class="flex">
                    <a href="{{ route('dashboard.user.edit', Auth::id()) }}" class="mr-4">Hey {{ Auth::user()->name }}
                        !</a>
                    <a href="{{ route('welcome') }}">Home Screen</a>
                </div>
            </div>
        </nav>

        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
@yield('post_content')
</body>
</html>
