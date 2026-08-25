<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <p class="text-gray-700">Welcome back, {{ Auth::user()->name }}.</p>
                <div class="mt-4 space-x-3">
                    <a href="{{ route('home.public') }}" class="text-indigo-600 hover:underline">Visit website</a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:underline">Open admin panel</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
