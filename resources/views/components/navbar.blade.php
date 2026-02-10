<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-14">

        {{-- LOGO --}}
        <div class="flex items-center flex-1">
            <a href="{{ route('dashboard') }}" class="text-[#0a66c2] mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10">
                    <path d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.25 6.5 1.75 1.75 0 016.5 8.25zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z"></path>
                </svg>
            </a>
        </div>

        {{-- MENU --}}
        <div class="flex items-center space-x-1 md:space-x-6">
            @auth

            {{-- SEARCH --}}
            <div class="hidden md:block relative">
                <form action="{{ route('users.index') }}" method="GET"
                    class="hidden md:block relative">

                    <input type="text"
                        name="search"
                        placeholder="Recherche utilisateur..."
                        value="{{ request('search') }}"
                        class="bg-[#edf3f8] border-none rounded text-sm w-64 py-2 pl-10
                  focus:ring-black focus:w-80 transition-all duration-300">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 absolute left-3 top-2.5 text-gray-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>

            </div>

            {{-- ACCUEIL --}}
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center text-gray-600 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M23 9v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9l10-7z" />
                </svg>
                <span class="text-[11px] hidden md:block">Accueil</span>
            </a>

            {{-- Notifications --}}
            <div class="relative">
                <button type="button" id="notifications-button"
                    class="flex flex-col items-center text-gray-600 hover:text-black transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2zm6-6V11a6 6 0 0 0-5-5.91V4a1 1 0 1 0-2 0v1.09A6 6 0 0 0 6 11v5l-2 2v1h16v-1l-2-2z" />
                    </svg>
                    <span class="text-[11px] hidden md:block">Notification</span>
                </button>
                <div id="notifications-panel"
                    class="absolute right-0 top-10 w-64 bg-white shadow-lg rounded border hidden">
                    @forelse(auth()->user()->notifications()->get() as $notification)
                        <div>{{$notification->data['message'] }}</div>

                    @empty
                    <div class="px-4 py-3 text-sm text-gray-600">Aucune notification.</div>
                    @endforelse
                </div>
            </div>

            {{-- OFFRES --}}
            @role('candidat')
            <a href="{{ route('candidat.jobs.index') }}"
                class="flex flex-col items-center text-gray-600 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4
                    a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8
                    a2 2 0 0 0-2-2z" />
                </svg>
                <span class="text-[11px] hidden md:block">Offres</span>
            </a>
            @endrole

            {{-- OFFRES RECRUTEUR --}}
            @role('recruteur')
            <a href="{{ route('recruteur.jobs.index') }}"
                class="flex flex-col items-center text-gray-600 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M3 6h18v2H3zm0 5h18v2H3zm0 5h18v2H3z" />
                </svg>
                <span class="text-[11px] hidden md:block">Mes Offres</span>
            </a>
            @endrole

            {{-- AMIS (CANDIDAT) --}}
            @role('candidat')
            <a href="{{ route('candidat.friends') }}"
                class="flex flex-col items-center text-gray-600 hover:text-black transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3
                    1.34-3 3 1.34 3 3 3zM8 11c1.66 0
                    3-1.34 3-3S9.66 5 8 5 5
                    6.34 5 8s1.34 3 3 3z" />
                </svg>
                <span class="text-[11px] hidden md:block">Amis</span>
            </a>
            @endrole


            <div class="flex flex-col items-center group relative cursor-pointer">
                <div class="h-6 w-6 rounded-full bg-gray-300 overflow-hidden">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0a66c2&color=fff' }}"  alt="Avatar">
                </div>
                <div class="flex items-center space-x-1">
                    <span class="text-[11px] hidden md:block">Vous</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10
                              10.586l3.293-3.293a1 1 0 111.414
                              1.414l-4 4a1 1 0 01-1.414
                              0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="absolute right-0 top-10 w-40 bg-white shadow-lg rounded border hidden group-hover:block">
                    <a href="{{ route('profile.show') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Profil</a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            @else
            <a href="{{ route('login') }}"
                class="text-gray-500 hover:text-gray-800 font-semibold px-4 py-2">
                S'identifier
            </a>
            <a href="{{ route('registerForm') }}"
                class="border-2 border-[#0a66c2] text-[#0a66c2]
                   hover:bg-blue-50 font-semibold px-5 py-2 rounded-full transition">
                S'inscrire
            </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById('notifications-button');
        const panel = document.getElementById('notifications-panel');
        if (!button || !panel) return;

        const closePanel = () => panel.classList.add('hidden');

        button.addEventListener('click', (event) => {
            event.stopPropagation();
            panel.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (panel.classList.contains('hidden')) return;
            if (!panel.contains(event.target)) closePanel();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closePanel();
        });
    });
</script>
