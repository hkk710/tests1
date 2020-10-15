@extends('layouts.dashboard')

@section('title', 'Manage Roles | ')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white rounded p-4 shadow m-4">
            <div class="flex justify-between">
                <h1 class="text-2xl uppercase">Manage Roles</h1>
                <a href="{{ route('dashboard.role.create') }}" class="btn green flex">
                    <img src="{{ asset('icons/file-plus_white.svg') }}" alt="Plus" width="16"/>
                    <span class="ml-2">Create New</span>
                </a>
            </div>

            <div class="overflow-auto mb-4">
                <table class="mt-4 w-full">
                    <tr>
                        <th class="bg-blue-100 border text-left px-8 py-2">Name</th>
                        <th class="bg-blue-100 border text-left px-8 py-2">Actions</th>
                    </tr>

                    @foreach($roles as $role)
                        <tr>
                            <td class="border px-8 py-2">{{ $role->name }}</td>
                            <td class="border px-8 py-2">
                                <div class="flex">
                                    <a href="{{ route('dashboard.role.edit', $role->id) }}"
                                       class="btn yellow mr-2">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{ $roles->links() }}
        </div>
    </div>
@endsection
