@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-10">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-200">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            Modifier l'offre
        </h1>

        <form action="{{ route('recruteur.jobs.update',$job) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Titre du poste
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title',$job->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]">
            </div>

            {{-- Location --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Localisation
                </label>
                <input type="text"
                       name="location"
                       value="{{ old('location',$job->location) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            {{-- Salary --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Salaire
                </label>
                <input type="text"
                       name="salary"
                       value="{{ old('salary',$job->salary) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description"
                          rows="6"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('description',$job->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('dashboard') }}"
                   class="px-5 py-2 border border-gray-300 rounded-lg font-bold text-gray-600 hover:bg-gray-100">
                    Annuler
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-[#0a66c2] text-white rounded-lg font-bold hover:bg-[#004182]">
                    Enregistrer
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
