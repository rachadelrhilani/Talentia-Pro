@extends('layouts.app')

@section('content')
<div class=" min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="h-16 bg-[#a0b4b7]"></div>
                
                <div class="px-4 -mt-8 mb-4 flex flex-col items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" 
                         class="w-16 h-16 rounded-full border-2 border-white shadow-sm" alt="Avatar">
                    <h2 class="mt-3 font-semibold text-gray-900 hover:underline cursor-pointer">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-xs text-gray-500 text-center mt-1">Étudiant à YouCode / Développeur Fullstack</p>
                </div>

                <div class="border-t border-gray-200 py-3">
                    <a href="{{ route('candidat.friends') }}" class="px-4 py-1 flex justify-between hover:bg-gray-100 transition">
                        <span class="text-xs text-gray-500 font-semibold">Relations</span>
                        <span class="text-xs text-[#0a66c2] font-bold">42</span>
                    </a>
                </div>

                <a href="{{ route('profile.show') }}" class="border-t border-gray-200 px-4 py-3 flex items-center hover:bg-gray-100 transition group">
                    <svg class="w-4 h-4 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/></svg>
                    <span class="text-xs font-bold text-gray-700">Accéder à mon profil CV</span>
                </a>
            </div>
        </div>

        <div class="md:col-span-6 space-y-4">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-900 mb-4">Offres d'emploi suggérées</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-3 border-b border-gray-100 pb-4 last:border-0">
                        <div class="w-12 h-12 bg-blue-100 flex-shrink-0 flex items-center justify-center text-blue-600 font-bold rounded">
                            CO
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-[#0a66c2] hover:underline cursor-pointer">Développeur Laravel Senior</h4>
                            <p class="text-xs text-gray-800">OCP Group · Casablanca</p>
                            <p class="text-[10px] text-gray-500 mt-1">Il y a 2 heures · 15 candidatures</p>
                        </div>
                        <a href="{{ route('candidat.jobs.index') }}" class="border border-[#0a66c2] text-[#0a66c2] px-3 py-1 rounded-full text-xs font-bold hover:bg-blue-50">
                            Voir
                        </a>
                    </div>
                </div>

                <a href="{{ route('candidat.jobs.index') }}" class="block text-center text-gray-500 font-bold text-sm mt-4 hover:bg-gray-100 p-2 rounded transition">
                    Voir toutes les offres
                </a>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-900 text-sm mb-4">Ajouter à votre réseau</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="https://i.pravatar.cc/150?u=recruiter" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-xs font-bold">Ahmed Benani</p>
                                <p class="text-[10px] text-gray-500">Recruteur chez Talentia</p>
                            </div>
                        </div>
                        <button class="border border-gray-500 rounded-full p-1 hover:bg-gray-100">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        </button>
                    </div>
                </div>

                <a href="{{ route('candidat.friends') }}" class="block text-gray-500 font-bold text-xs mt-4 hover:underline">
                    Voir toutes les suggestions →
                </a>
            </div>
        </div>

    </div>
</div>
@endsection