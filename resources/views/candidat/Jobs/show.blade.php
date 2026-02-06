@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-8">
    @if(session('error'))
    <div class="max-w-4xl mx-auto px-4 mb-6">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl flex justify-between items-center" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    </div>
    @endif

    <div class="max-w-4xl mx-auto px-4">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            @if($job->image)
            <div class="w-full h-64 bg-gray-200 overflow-hidden">
                <img src="{{ asset('storage/' . $job->image) }}" alt="{{ $job->title }}" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="p-6 sm:p-8">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-700 mt-1">
                                <span class="hover:underline cursor-pointer text-[#0a66c2] font-semibold">
                                    {{ $job->company->name ?? 'Entreprise Partenaire' }}
                                </span> 
                                · {{ $job->location ?? 'Maroc' }}
                            </p>

                           
                            @if($job->salary)
                            <div class="mt-2 inline-block bg-emerald-50 text-emerald-700 px-3 py-1 rounded-md text-sm font-bold border border-emerald-100">
                                {{ $job->salary }}
                            </div>
                            @endif

                            <p class="text-sm text-gray-500 mt-3">
                                Postée {{ $job->created_at->diffForHumans() }} · 
                                <span class="text-indigo-600 font-bold">{{ $job->applications()->count() }} personnes ont déjà postulé</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-4">
                    <div class="flex items-center text-gray-700 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zM10 4h4v2h-4z"/></svg>
                        <span class="text-sm font-medium">{{ $job->contract_type }}</span>
                    </div>
                    <div class="flex items-center text-gray-700 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <span class="text-sm font-medium">11-50 employés</span>
                    </div>
                </div>

                <div class="mt-8 flex items-center space-x-3">
                    <form method="POST" action="{{ route('candidat.jobs.apply', $job) }}">
                        @csrf
                        <button class="bg-[#0a66c2] hover:bg-[#004182] text-white font-bold py-2.5 px-8 rounded-full transition duration-200 flex items-center shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Postuler maintenant
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-100 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">À propos de l'offre</h3>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base">
                    {{ $job->description }}
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">À propos de l'entreprise</h3>
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-gray-50 rounded border border-gray-200 flex items-center justify-center overflow-hidden">
                        <span class="text-xl font-bold text-gray-400 italic">{{ substr($job->company->name ?? 'T', 0, 1) }}</span>
                </div>
                <div>
                    <p class="font-bold text-gray-900">{{ $job->company->name ?? 'Talentia Group' }}</p>
                    <p class="text-sm text-gray-500">Recrutement et Services RH</p>
                </div>
            </div>
            <button class="mt-4 text-[#0a66c2] font-bold hover:underline transition">Voir la page de l'entreprise</button>
        </div>
    </div>
</div>
@endsection