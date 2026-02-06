<div> 
    <div class="grid grid-cols-1 gap-4">
        
        @forelse($jobs as $job)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-md transition duration-300">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <h2 class="text-xl font-bold text-gray-800">{{ $job->title }}</h2>
                            @if($job->is_closed)
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Fermée</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Active</span>
                            @endif
                        </div>
                        
                        <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                            <span class="flex items-center capitalize">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $job->location }}
                            </span>
                            <span class="flex items-center italic">
                                Postée le {{ $job->created_at->format('d M, Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('recruteur.jobs.applications', $job) }}" 
                           class="inline-flex items-center bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-semibold px-4 py-2 rounded-lg transition">
                            <span class="mr-2">{{ $job->applications_count ?? 0 }}</span>
                            Candidatures
                        </a>

                        <div class="flex border-l pl-3 gap-2">
                            <a href="{{ route('recruteur.jobs.edit', $job) }}" class="p-2 text-gray-400 hover:text-blue-600 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            
                            @if(!$job->is_closed)
                            <form action="{{ route('recruteur.jobs.close', $job) }}" method="POST" onsubmit="return confirm('Fermer cette offre ?')">
                                @csrf
                                <button class="p-2 text-gray-400 hover:text-red-600 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <p class="text-gray-500 text-lg">Vous n'avez pas encore publié d'offres.</p>
            </div>
        @endforelse

    </div>
</div>