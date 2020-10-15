@extends('layouts.dashboard')

@section('title', 'Update | ')

@section('styles')
    <link href="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <h1 class="text-2xl uppercase">Update</h1>

            <form action="{{ route('dashboard.file.update', $file->id) }}" class="mt-4" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('put')

                <div>
                    <label for="url">URL</label>
                    <input type="url" class="form-control mt-2 @error('url') is-invalid @enderror"
                           placeholder="URL..." value="{{ old('url') ?? $file->url }}" id="url" name="url" autofocus
                           required/>

                    @error('url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="name">Name <small>(Optional)</small></label>
                    <input type="name" class="form-control mt-2 @error('name') is-invalid @enderror"
                           placeholder="Name..." value="{{ old('name') ?? $file->name }}" id="name" name="name"
                           autofocus/>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="tags">Tags</label>
                    <div class="mt-2">
                        <select type="text" class="@error('tags') is-invalid @enderror"
                                id="tags" name="tags[]" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    {{ $file->tags()->where('tag_id', $tag->id)->count() ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('tags.*')
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

                    <button class="btn yellow ml-4 flex items-center"
                            @click="url('{{ route('dashboard.file.index') }}')" type="button">
                        <img src="{{ asset('icons/edit-2.svg') }}" alt="Save" width="16"/>
                        <span class="ml-2">Cancel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('post_content')
    <script src="https://cdn.tiny.cloud/1/umtetnrmfid5jg2u1d67ds1j28zlu7mdlny89b17kry63prx/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.js"
            type="text/javascript"></script>
    <script>
        tinymce.init({
            selector: '#our_organization_description',
            plugins: 'lists',
            toolbar: 'bold italic underline | bullist'
        });

        new Selectr('#tags', {
            customClass: 'text-sm'
        });
    </script>
@endsection
