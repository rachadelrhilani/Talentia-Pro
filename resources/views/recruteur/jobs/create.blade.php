@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4">
        
        <div class="mb-4 flex items-center text-gray-600 hover:text-black cursor-pointer transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <a href="{{ route('recruteur.jobs.index') }}" class="text-sm font-semibold">Retour aux offres</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h1 class="text-2xl font-semibold text-gray-900">Publier une offre d'emploi</h1>
                <p class="text-sm text-gray-500 mt-1">Augmentez vos chances de trouver le candidat idéal en étant précis.</p>
            </div>

            <form method="POST" action="{{ route('recruteur.jobs.store') }}" class="p-8 space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Intitulé du poste *</label>
                    <input type="text" name="title" required
                        placeholder="Ex: Développeur Fullstack Laravel"
                        class="w-full border border-gray-400 p-3 rounded-lg text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
                    @error('title') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Type de contrat *</label>
                    <select name="contract_type" required
                        class="w-full border border-gray-400 p-3 rounded-lg text-black bg-white focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200 appearance-none">
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Stage">Stage / Alternance</option>
                        <option value="Freelance">Freelance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Description du poste *</label>
                    <textarea name="description" rows="8" required
                        placeholder="Missions, compétences requises, avantages..."
                        class="w-full border border-gray-400 p-3 rounded-lg text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200"></textarea>
                    <p class="text-[11px] text-gray-400 mt-1 italic">Conseil : Détaillez bien les technologies utilisées.</p>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-4">
                    <a href="{{ route('recruteur.jobs.index') }}" class="text-gray-600 font-semibold hover:bg-gray-100 px-6 py-2 rounded-full transition">
                        Annuler
                    </a>
                    <button type="submit" class="bg-[#0a66c2] hover:bg-[#004182] text-white font-semibold px-8 py-2.5 rounded-full transition duration-200 shadow-md">
                        Publier l'offre
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 flex items-start space-x-3 text-gray-500">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            <p class="text-xs">
                En publiant cette offre, vous acceptez les politiques de recrutement de Talentia. Votre annonce sera visible par des milliers de candidats potentiels.
            </p>
        </div>
    </div>
</div>
@endsection