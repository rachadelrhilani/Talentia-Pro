@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <div class="p-6 sm:p-8">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-20 h-20 bg-white border border-gray-200 rounded-lg flex items-center justify-center overflow-hidden shadow-sm">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($job->company->name ?? 'C') }}&background=0a66c2&color=fff&size=128" alt="Logo">
                        </div>
                        
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-700 mt-1">
                                <span class="hover:underline cursor-pointer text-[#0a66c2] font-semibold">
                                    {{ $job->company->name ?? 'Entreprise Partenaire' }}
                                </span> 
                                · {{ $job->location ?? 'Maroc' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Postée {{ $job->created_at->diffForHumans() }} · 
                                <span class="text-green-600 font-bold">25 personnes ont déjà postulé</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-4">
                    <div class="flex items-center text-gray-700">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zM10 4h4v2h-4z"/></svg>
                        <span class="text-sm">{{ $job->contract_type }}</span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <span class="text-sm">11-50 employés</span>
                    </div>
                </div>

                <div class="mt-8 flex items-center space-x-3">
                    <form method="POST" action="{{ route('candidat.jobs.apply', $job) }}">
                        @csrf
                        <button class="bg-[#0a66c2] hover:bg-[#004182] text-white font-bold py-2.5 px-6 rounded-full transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Candidature simplifiée
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-100 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">À propos de l'offre</h3>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $job->description }}
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">À propos de l'entreprise</h3>
            <div class="flex items-center space-x-4">
                 <div class="w-12 h-12 bg-gray-100 rounded border border-gray-200 flex items-center justify-center">
                    <span class="text-xl font-bold text-gray-400 italic">T</span>
                </div>
                <div>
                    <p class="font-bold text-gray-900">{{ $job->company->name ?? 'Talentia Group' }}</p>
                    <p class="text-sm text-gray-500">12 450 abonnés</p>
                </div>
            </div>
            <button class="mt-4 text-[#0a66c2] font-bold hover:underline">Suivre</button>
        </div>
    </div>
</div>
@endsection