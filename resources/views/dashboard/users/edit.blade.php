@extends('layouts.dashboard')

@section('title', 'Edit User details | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Update An Event</h1>

            <form action="{{ route('dashboard.user.update', $user->id) }}" class="mt-4" method="post"
                  enctype="multipart/form-data" ref="updateForm">
                @csrf
                @method('put')

                <div>
                    <label for="name">Name</label>
                    <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror"
                           placeholder="Name..." value="{{ old('name') ?? $user->name }}" id="name" name="name"
                           autofocus/>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control mt-2 @error('email') is-invalid @enderror"
                           placeholder="Email..." value="{{ old('email') ?? $user->email }}" id="email" name="email"
                           autofocus/>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password">Password <small>(leave empty if don't want to change)</small></label>
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

                @can('manage_users')
                    <div class="mt-4">
                        <label for="role">Role</label>
                        <select type="role" class="form-control mt-2 @error('role') is-invalid @enderror" id="role"
                                name="role">
                            <option value="">No role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                        @if ((old('role') ?? optional($user->roles()->first())->id) == $role->id) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('role')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                @endcan

                <div class="mt-4 flex">
                    <button class="btn green flex items-center" type="submit">
                        <img src="{{ asset('icons/save_white.svg') }}" alt="Save" width="16"/>
                        <span class="ml-2">Update</span>
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
