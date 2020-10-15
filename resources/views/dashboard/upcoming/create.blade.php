@extends('layouts.dashboard')

@section('title', 'Create Upcoming event | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Create A new Upcoming</h1>

            <form action="{{ route('dashboard.upcoming.store') }}" class="mt-4" method="post"
                  enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="title">Title</label>
                    <input type="text" class="form-control mt-2 @error('title') is-invalid @enderror"
                           placeholder="Title..." value="{{ old('title') }}" id="title" name="title" autofocus/>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control mt-2 @error('description') is-invalid @enderror"
                              placeholder="Description..." id="description" name="description"
                              rows="10">{{ old('description') }}</textarea>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="image">Image</label>
                    <input type="file" class="form-control mt-2 @error('image') is-invalid @enderror"
                           id="image" name="image"/>

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="event">Event</label>
                    <select type="text" class="form-control mt-2 @error('event') is-invalid @enderror"
                            id="event" name="event">
                        <option value="research" @if (old('event') == 'research') selected @endif>Enduro Research</option>
                        <option value="prosthesis" @if (old('event') == 'prosthesis') selected @endif>Enduro Prosthesis</option>
                        <option value="evc" @if (old('event') == 'evc') selected @endif>Enduro EVC</option>
                        <option value="companion" @if (old('event') == 'companion') selected @endif>Enduro Companion</option>
                        <option value="fit" @if (old('event') == 'fit') selected @endif>Enduro Fit</option>
                    </select>

                    @error('event')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
    <script src="https://cdn.tiny.cloud/1/umtetnrmfid5jg2u1d67ds1j28zlu7mdlny89b17kry63prx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description'
        });
    </script>
@endsection
