@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Servers</h2>
        <a href="{{ route('servers.create') }}" class="btn-primary">Add Server</a>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($servers as $server)
        <div class="card">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $server->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-dark-text-secondary">{{ $server->ip_address }}</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full 
                    {{ $server->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                    {{ $server->status }}
                </span>
            </div>
            <div class="mt-4 space-y-2">
                <p class="text-sm text-gray-600 dark:text-dark-text-secondary">
                    <span class="font-medium">Operating System:</span> {{ $server->operating_system }}
                </p>
                <p class="text-sm text-gray-600 dark:text-dark-text-secondary">
                    <span class="font-medium">Environment:</span> {{ $server->environment }}
                </p>
            </div>
            <div class="mt-4 flex space-x-3">
                <a href="{{ route('servers.show', $server) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">View Details</a>
                <a href="{{ route('servers.edit', $server) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">Edit</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
