<!-- resources/views/partials/nav.blade.php -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-indigo-600">MyApp</a>
            </div>
            
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="px-3 py-2 rounded-md text-gray-600 hover:text-indigo-600 transition">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="px-3 py-2 rounded-md text-gray-600 hover:text-indigo-600 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-3 py-2 rounded-md text-gray-600 hover:text-indigo-600 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-3 py-2 rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>