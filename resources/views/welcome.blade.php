@extends('layouts.root')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Welcome to My Awesome App
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Start your amazing journey with us
            </p>
            
            @guest
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" 
                   class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="inline-block px-6 py-3 bg-white border-2 border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                    Register
                </a>
            </div>
            @endguest
        </div>

        @auth
        <div class="mt-16 text-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Welcome back, {{ Auth::user()->name }}!
            </h2>
            <a href="{{ route('dashboard') }}" 
               class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Go to Dashboard
            </a>
        </div>
        @endauth

        <!-- Feature Section -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-indigo-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Fast Performance</h3>
                <p class="text-gray-600">Lightning-fast response times and smooth interactions.</p>
            </div>
            
            <!-- Add more feature cards here -->
        </div>
    </div>
</div>
@endsection