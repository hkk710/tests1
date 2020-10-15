@extends('layouts.dashboard')

@section('title', 'Manage Files | ')

@section('styles')
    <link href="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <div class="flex justify-between">
                <h1 class="text-2xl uppercase">Manage Files</h1>
                <a href="{{ route('dashboard.file.create') }}" class="btn green flex">
                    <img src="{{ asset('icons/file-plus_white.svg') }}" alt="Plus" width="16"/>
                    <span class="ml-2">Create New</span>
                </a>
            </div>

            <form action="{{ route('dashboard.file.index') }}" class="mt-4 sm:flex justify-between w-full">
                <div class="w-full sm:w-1/3">
                    Search By Name:
                    <input type="text" class="form-control" value="{{ request('q') }}" name="q" placeholder="Only works with files with custom name" />
                </div>

                <div class="flex w-full sm:w-2/5 sm:mt-0 mt-2 items-end">
                    <div class="flex-1">
                        Filter by Tags:
                        <select name="tags[]" id="tags" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, request('tags') ?? []) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn green ml-2">Search</button>
                    </div>
                </div>
            </form>

            <div class="my-4 grid grid-auto gap-4">
                @foreach($files as $file)
                    @php
                        $color = '';
                        switch ($file->file_type) {
                            case 'document': $color = 'border-blue-500'; break;
                            case 'spreadsheets': $color = 'border-green-500'; break;
                            case 'presentation': $color = 'border-orange-400'; break;
                            case 'forms': $color = 'border-purple-500'; break;
                            case 'file': $color = 'border-gray-500'; break;
                        }
                    @endphp
                    <div @click="url('{{ $file->url }}')"
                         class="flex flex-col rounded shadow bg-white border cursor-pointer {{ $color }}">
                        <div class="p-4 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex items-center">
                                    <img src="{{ asset("images/docs/{$file->file_type}.png") }}"
                                         alt="{{ $file->file_type }}" draggable="false" width="16"/>
                                    <span class="ml-2 text-lg">{{ $file->name }}</span>
                                </div>
                                <span class="opacity-75 text-sm">By {{ $file->user->name }}</span>
                                <span class="opacity-50 text-xs">@ {{ $file->created_at->format('d/m/Y') }}</span>
                                <div class="flex flex-wrap">
                                    @foreach($file->tags as $tag)
                                        <span
                                            class="rounded-full text-xs bg-gray-300 mr-2 px-2 py-1 mt-2">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @can ('update', $file)
                                <div class="text-sm mt-2">
                                    <button class="cursor-pointer underline mr-2"
                                            @click.stop="url('{{ route('dashboard.file.edit', $file->id) }}')">Edit
                                    </button>
                                    <button class="cursor-pointer underline"
                                            @click.stop="warn($refs['file-{{ $file->id }}-delete'].submit)">Delete
                                    </button>

                                    <form action="{{ route('dashboard.file.destroy', $file->id) }}"
                                          ref="file-{{ $file->id }}-delete" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $files->withQueryString()->links() }}
        </div>
    </div>
@endsection

@section('post_content')
    <script src="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.js"
            type="text/javascript"></script>
    <script>
        new Selectr('#tags', {
            customClass: 'text-sm'
        });
    </script>
@endsection
