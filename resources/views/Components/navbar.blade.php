<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="/" class="text-xl font-bold text-blue-600">
            JobPlatform
        </a>

        <div class="space-x-4">
            @auth
                <span class="text-gray-600">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-500 hover:underline">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Sign up
                </a>
            @endauth
        </div>
    </div>
</nav>
