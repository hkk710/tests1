@extends('layouts.dashboard')

@section('title', 'Create User | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Create A new User</h1>

            <form action="{{ route('dashboard.user.store') }}" class="mt-4" method="post"
                  enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="name">Name</label>
                    <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror"
                           placeholder="Name..." value="{{ old('name') }}" id="name" name="name" autofocus/>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control mt-2 @error('email') is-invalid @enderror"
                           placeholder="Email..." value="{{ old('email') }}" id="email" name="email" autofocus/>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control mt-2 @error('password') is-invalid @enderror"
                           placeholder="Password..." value="{{ old('password') }}" id="password" name="password"
                           autofocus/>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password-confirm">Confirm Password</label>
                    <input type="password" class="form-control mt-2" autofocus
                           placeholder="Confirm Password..." value="{{ old('password_confirmation') }}"
                           id="password-confirm" name="password_confirmation"/>
                </div>

                <div class="mt-4 flex">
                    <button class="btn green flex items-center" type="submit">
                        <img src="{{ asset('icons/save_white.svg') }}" alt="Save" width="16"/>
                        <span class="ml-2">Save</span>
                    </button>

                    <button class="btn yellow ml-4 flex items-center" type="reset">
                        <img src="{{ asset('icons/edit-2.svg') }}" alt="Save" width="16"/>
                        <span class="ml-2">Clear</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('post_content')
    <script src="https://cdn.tiny.cloud/1/umtetnrmfid5jg2u1d67ds1j28zlu7mdlny89b17kry63prx/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description'
        });
    </script>
@endsection
