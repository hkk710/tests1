@extends('layouts.dashboard')

@section('title', 'Edit A Member | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Update A Member</h1>

            <form action="{{ route('dashboard.member.update', $member->id) }}" class="mt-4" method="post"
                  enctype="multipart/form-data" ref="updateForm">
                @csrf
                @method('put')

                <div>
                    <label for="name">Name</label>
                    <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror"
                           placeholder="Name..." value="{{ old('name') ?? $member->name }}" id="name" name="name" autofocus/>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="our_organization_description">Our Organization Description</label>
                    <textarea type="text" class="form-control mt-2 @error('our_organization_description') is-invalid @enderror"
                              placeholder="Our Organization Description..." id="our_organization_description" name="our_organization_description"
                              rows="10">{{ old('our_organization_description') ?? $member->our_organization_description }}</textarea>

                    @error('our_organization_description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="image">Image <small>(Leave empty for not changing)</small></label>
                    <input type="file" class="form-control mt-2 @error('image') is-invalid @enderror"
                           id="image" name="image"/>

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="qualification">Qualification</label>
                    <input type="text" class="form-control mt-2 @error('qualification') is-invalid @enderror"
                           placeholder="Qualification..." value="{{ old('qualification') ?? $member->qualification }}" id="qualification"
                           name="qualification"/>

                    @error('qualification')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4 md:flex">
                    <div class="md:mr-2 flex-1">
                        <label for="position">Position</label>
                        <input type="text" class="form-control mt-2 @error('position') is-invalid @enderror"
                               placeholder="Position..." value="{{ old('position') ?? $member->position }}" id="position"
                               name="position"/>

                        @error('position')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="md:ml-2 flex-1 mt-4 md:mt-0">
                        <label for="priority">Display Order</label>
                        <input type="number" class="form-control mt-2 @error('priority') is-invalid @enderror"
                               placeholder="Display Order..." value="{{ old('priority') ?? $member->priority }}" id="priority" name="priority" />

                        @error('priority')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
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

@section('post_content')
    <script src="https://cdn.tiny.cloud/1/umtetnrmfid5jg2u1d67ds1j28zlu7mdlny89b17kry63prx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#our_organization_description',
            plugins: 'lists',
            toolbar: 'bold italic underline | bullist'
        });
    </script>
@endsection
