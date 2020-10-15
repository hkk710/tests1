@extends('layouts.dashboard')

@section('title', 'Create Home Page | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Create Home Page</h1>

            <form action="{{ route('dashboard.pages.home.store') }}" class="mt-4" method="post"
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
                    <label for="subtitle">Sub Title</label>
                    <input type="text" class="form-control mt-2 @error('subtitle') is-invalid @enderror"
                           placeholder="Sub Title..." value="{{ old('subtitle') }}" id="subtitle" name="subtitle"/>

                    @error('subtitle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="bg">Background Image</label>
                    <input type="file" class="form-control mt-2 @error('bg') is-invalid @enderror"
                           id="bg" name="bg"/>

                    @error('bg')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4 md:flex">
                    <div class="md:mr-2 flex-1">
                        <label for="main_link_text">Main Link Text</label>
                        <input type="text" class="form-control mt-2 @error('main_link_text') is-invalid @enderror"
                               placeholder="Main Link Text..." value="{{ old('main_link_text') }}" id="main_link_text"
                               name="main_link_text"/>

                        @error('main_link_text')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="md:ml-2 flex-1 mt-4 md:mt-0">
                        <label for="main_link">Main Link</label>
                        <input type="text" class="form-control mt-2 @error('main_link') is-invalid @enderror"
                               placeholder="Main Link..." value="{{ old('main_link') }}" id="main_link" name="main_link"/>

                        @error('main_link')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 md:flex">
                    <div class="md:mr-2 flex-1">
                        <label for="sub_link_text">Sub Link Text</label>
                        <input type="text" class="form-control mt-2 @error('sub_link_text') is-invalid @enderror"
                               placeholder="Sub Link Text..." value="{{ old('sub_link_text') }}" id="sub_link_text"
                               name="sub_link_text"/>

                        @error('sub_link_text')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="md:ml-2 flex-1 mt-4 md:mt-0">
                        <label for="sub_link">Sub Link</label>
                        <input type="text" class="form-control mt-2 @error('sub_link') is-invalid @enderror"
                               placeholder="Sub Link..." value="{{ old('sub_link') }}" id="sub_link" name="sub_link"/>

                        @error('sub_link')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 flex">
                    <button class="btn green flex items-center" type="submit">
                        <img src="{{ asset('icons/save_white.svg') }}" alt="Save" width="16"/>
                        <span class="ml-2">Save</span>
                    </button>

                    <button formaction="{{ route('dashboard.pages.home.preview') }}" type="submit"
                            class="btn flex items-center ml-4">
                        <img src="{{ asset('icons/eye_white.svg') }}" alt="Save" width="16"/>
                        <span class="ml-2">Preview</span>
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
