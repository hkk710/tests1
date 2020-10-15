@extends('layouts.app')

@section('title', 'Login | ')

@section('content')
    @include('partials.navbar')

    <div class="form mx-auto px-4 my-8">
        <form method="POST" class="shadow-lg bg-white px-6 py-4" action="{{ route('login') }}">
            @csrf
            <div class="text-center uppercase text-xl">Welcome!</div>
            <div class="text-center opacity-75">Access the admin dashboard by logging in</div>

            <div class="mt-4">
                <label for="email" class="">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" placeholder="Email"
                           class="form-control mt-2 @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password"
                       class="form-control mt-2 @error('password') is-invalid @enderror" name="password"
                       required autocomplete="current-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>

    @include('partials.footer')
@endsection
