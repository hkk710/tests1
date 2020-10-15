@extends('layouts.dashboard')

@section('title', 'Edit A Tag | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Update A Tag</h1>

            <form action="{{ route('dashboard.tag.update', $tag->id) }}" class="mt-4" method="post"
                  enctype="multipart/form-data" ref="updateForm">
                @csrf
                @method('put')

                <div>
                    <label for="name">Name</label>
                    <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror"
                           placeholder="Name..." value="{{ old('name') ?? $tag->name }}" id="name" name="name"
                           autofocus/>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

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
