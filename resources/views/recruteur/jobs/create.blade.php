@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4">

        <div class="mb-4 flex items-center text-gray-600 hover:text-black cursor-pointer transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <a href="{{ route('recruteur.jobs.index') }}" class="text-sm font-semibold">Retour aux offres</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h1 class="text-2xl font-semibold text-gray-900">Publier une offre d'emploi</h1>
                <p class="text-sm text-gray-500 mt-1">Augmentez vos chances de trouver le candidat idéal en étant précis.</p>
            </div>

            <form method="POST" action="{{ route('recruteur.jobs.store') }}" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Intitulé du poste *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        placeholder="Ex: Développeur Fullstack Laravel"
                        class="w-full border border-gray-300 p-3 rounded-lg text-black focus:border-[#0a66c2] focus:ring-1 focus:ring-[#0a66c2] outline-none transition duration-200">
                    @error('title') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Location --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Localisation *</label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                            placeholder="Ex: Casablanca, Remote..."
                            class="w-full border border-gray-300 p-3 rounded-lg text-black focus:border-[#0a66c2] focus:ring-1 focus:ring-[#0a66c2] outline-none">
                        @error('location') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>

                    {{-- Contract Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Type de contrat *</label>
                        <select name="contract_type" required
                            class="w-full border border-gray-300 p-3 rounded-lg text-black bg-white focus:border-[#0a66c2] focus:ring-1 focus:ring-[#0a66c2] outline-none transition duration-200 appearance-none">
                            <option value="" disabled selected>Choisir un type...</option>
                            @foreach(['CDI', 'CDD', 'Stage', 'Freelance', 'Full-time'] as $type)
                            <option value="{{ $type }}" {{ old('contract_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                        @error('contract_type') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Image de l'offre (Optionnel)</label>
                    <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#0a66c2] transition cursor-pointer relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0a66c2] hover:text-[#004182]">
                                    <span>Téléverser un fichier</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('image') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Salary --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Salaire (Optionnel)</label>
                    <input type="text" name="salary" value="{{ old('salary') }}"
                        placeholder="Ex: 8000 - 12000 DH"
                        class="w-full border border-gray-300 p-3 rounded-lg text-black focus:border-[#0a66c2] focus:ring-1 focus:ring-[#0a66c2] outline-none">
                    @error('salary') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Description du poste *</label>
                    <textarea name="description" rows="8" required
                        placeholder="Missions, compétences requises, avantages..."
                        class="w-full border border-gray-300 p-3 rounded-lg text-black focus:border-[#0a66c2] focus:ring-1 focus:ring-[#0a66c2] outline-none transition duration-200">{{ old('description') }}</textarea>
                    <p class="text-[11px] text-gray-400 mt-1 italic">Conseil : Détaillez bien les technologies utilisées.</p>
                    @error('description') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
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

        <div class="mt-6 flex items-start space-x-3 text-gray-500 text-[12px]">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
            </svg>
            <p>
                En publiant cette offre, vous acceptez les politiques de recrutement de Talentia. Votre annonce sera visible par des milliers de candidats potentiels.
            </p>
        </div>
    </div>
</div>
@endsection