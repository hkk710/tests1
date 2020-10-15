@extends('layouts.app')

@section('title', 'Contact Us | ')

@section('content')
    @include('partials.navbar')

    <div class="form mx-auto px-4 my-8">
        <form action="{{ route('contactus') }}" class="shadow-lg bg-white px-6 py-4" method="post">
            @csrf

            <div class="sm:flex">
                <div class="flex-1 sm:mr-4">
                    <label for="name">Name</label>
                    <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your name..." value="{{ old('name') }}" />

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="flex-1 mt-4 sm:mt-0">
                    <label for="email">Email</label>
                    <input type="email" class="form-control mt-2 @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your email..." />

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="feedback">Your Feedback</label>
                <textarea name="feedback" id="feedback" rows="6" class="form-control mt-2 @error('feedback') is-invalid @enderror" placeholder="Your valuable feedback...">{{ old('feedback') }}</textarea>

                @error('feedback')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <input type="submit" class="btn" value="Send Feedback" />
            </div>
        </form>
    </div>

    @include('partials.footer')
@endsection
