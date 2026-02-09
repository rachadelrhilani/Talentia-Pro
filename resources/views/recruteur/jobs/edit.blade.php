@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-10">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-200">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            Modifier l'offre
        </h1>

        <form action="{{ route('recruteur.jobs.update', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- 2. Champ Image --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Image de l'offre
                </label>

                {{-- Affichage de l'image actuelle --}}
                @if($job->image)
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-1">Image actuelle :</p>
                    <img src="{{ asset('storage/' . $job->image) }}" class="w-32 h-20 object-cover rounded-lg border">
                </div>
                @endif

                <input type="file" name="image" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                <p class="text-[11px] text-gray-400 mt-1">Laissez vide pour conserver l'image actuelle.</p>
                @error('image') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            {{-- Title --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Titre du poste
                </label>
                <input type="text"
                    name="title"
                    value="{{ old('title', $job->title) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Location --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">
                        Localisation
                    </label>
                    <input type="text"
                        name="location"
                        value="{{ old('location', $job->location) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]">
                </div>


                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">
                        Type de contrat
                    </label>
                    <select name="contract_type"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]">
                        @php
                        $types = ['CDI', 'CDD', 'Stage', 'Freelance', 'Full-time'];
                        @endphp
                        @foreach($types as $type)
                        <option value="{{ $type }}" {{ old('contract_type', $job->contract_type) == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Salary --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Salaire
                </label>
                <input type="text"
                    name="salary"
                    placeholder="Ex: 5000 DH"
                    value="{{ old('salary', $job->salary) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description"
                    rows="6"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]">{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2 border border-gray-300 rounded-lg font-bold text-gray-600 hover:bg-gray-100 transition">
                    Annuler
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-[#0a66c2] text-white rounded-lg font-bold hover:bg-[#004182] transition shadow-md">
                    Enregistrer les modifications
                </button>
            </div>

        </form>

    </div>

</div>
@endsection