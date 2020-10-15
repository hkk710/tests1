@extends('layouts.dashboard')

@section('title', 'Edit Home Page design | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <div class="flex justify-between">
                <h1 class="text-2xl uppercase">Edit Home Page</h1>
                <a href="{{ route('dashboard.pages.home.create') }}" class="btn green flex">
                    <img src="{{ asset('icons/file-plus_white.svg') }}" alt="Plus" width="16"/>
                    <span class="ml-2">Create New</span>
                </a>
            </div>

            <div class="overflow-auto mb-4">
                <table class="mt-4 w-full">
                    <tr>
                        <th class="bg-blue-100 border text-left px-8 py-2">Title</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Sub title</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Main Link Text</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Main Link</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Sub Link Text</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Sub Link</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Actions</th>
                    </tr>

                    @foreach($home_pages as $page)
                        <tr>
                            <td class="border px-8 py-2">{{ $page->title }}</td>
                            <td class="border px-8 py-2">{{ $page->subtitle }}</td>
                            <td class="border px-8 py-2">{{ $page->main_link_text }}</td>
                            <td class="border px-8 py-2">{{ $page->main_link }}</td>
                            <td class="border px-8 py-2">{{ $page->sub_link_text }}</td>
                            <td class="border px-8 py-2">{{ $page->sub_link }}</td>
                            <td class="border px-8 py-2">
                                <div class="flex">
                                    @if ($page->active) <span class="mr-2 py-2">Active!</span>
                                    @else <a href="{{ route('dashboard.pages.home.activate', $page->id) }}"
                                             class="btn green mr-2">Activate</a> @endif
                                    <a href="{{ route('dashboard.pages.home.edit', $page->id) }}"
                                       class="btn yellow mr-2">Edit</a>
                                    <a href="{{ route('dashboard.pages.home.show', $page->id) }}"
                                       class="btn">Preview</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{ $home_pages->links() }}
        </div>
    </div>
@endsection
