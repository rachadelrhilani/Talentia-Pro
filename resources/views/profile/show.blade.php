@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 my-10 px-4">
   @if(session('success'))
   <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex justify-between items-center" role="alert">
      <span class="block sm:inline font-bold">{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">
         &times;
      </button>
   </div>
   @endif

   <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations personnelles</h2>
      @error('email')
      <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
      @enderror
      <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
         @csrf
         @method('PUT')

         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
               <label class="block text-sm font-semibold text-gray-700 mb-1">Nom complet</label>
               <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 p-2.5 rounded-lg">
            </div>
            <div>
               <label class="block text-sm font-semibold text-gray-700 mb-1">Photo de profil</label>
               <input type="file" name="photo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
         </div>

         <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Bio</label>
            <textarea name="bio" rows="3" class="w-full border border-gray-300 p-2.5 rounded-lg">{{ $user->bio }}</textarea>
         </div>

         @role('candidat')
         <div class="mt-8 pt-8 border-t border-gray-100 space-y-6">
            <h3 class="text-xl font-bold text-indigo-600">Profil Professionnel</h3>

            <div>
               <label class="block text-sm font-semibold text-gray-700 mb-1">Titre du profil</label>
               <input type="text" name="title" value="{{ $profile->title ?? '' }}" class="w-full border border-gray-300 p-2.5 rounded-lg" placeholder="Ex: Développeur PHP / Laravel">
            </div>

            <div>
               <label class="block text-sm font-semibold text-gray-700 mb-1">Compétences</label>
               <select name="skills[]" id="skills-select" multiple class="w-full border border-gray-300 p-2.5 rounded-lg h-32">
                  @foreach($skills as $skill)
                  <option value="{{ $skill->id }}"
                     @if(isset($profile) && $profile->skills->contains($skill->id)) selected @endif>
                     {{ $skill->name }}
                  </option>
                  @endforeach
               </select>
               <p class="text-xs text-gray-400 mt-1 italic">Choisissez dans la liste ou tapez une nouvelle compétence puis appuyez sur "Entrée".</p>
            </div>
            <div class="space-y-4">
               <h4 class="font-bold text-gray-800 flex items-center gap-2">
                  <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  Dernière Expérience
               </h4>
               @php
               $latestExp = $profile->experiences->last();
               @endphp
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl">
                  <input type="text" name="exp_position"
                     value="{{ old('exp_position', $latestExp->position ?? '') }}"
                     placeholder="Poste (ex: Designer)" class="border p-2 rounded-lg">

                  <input type="text" name="exp_company"
                     value="{{ old('exp_company', $latestExp->company ?? '') }}"
                     placeholder="Entreprise" class="border p-2 rounded-lg">

                  <input type="date" name="exp_start_date"
                     value="{{ old('exp_start_date', $latestExp ? $latestExp->start_date : '') }}"
                     class="border p-2 rounded-lg">

                  <input type="date" name="exp_end_date"
                     value="{{ old('exp_end_date', ($latestExp && $latestExp->end_date) ? $latestExp->end_date : '') }}"
                     class="border p-2 rounded-lg">
               </div>
            </div>

            {{-- Education Section --}}
            <div class="space-y-4 mt-6">
               <h4 class="font-bold text-gray-800 flex items-center gap-2">
                  <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                     <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                  </svg>
                  Dernier Diplôme
               </h4>
               @php
               $latestEdu = $profile->educations->last();
               @endphp
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl">
                  <input type="text" name="edu_degree"
                     value="{{ old('edu_degree', $latestEdu->degree ?? '') }}"
                     placeholder="Diplôme (ex: Master)" class="border p-2 rounded-lg">

                  <input type="text" name="edu_school"
                     value="{{ old('edu_school', $latestEdu->school ?? '') }}"
                     placeholder="École/Université" class="border p-2 rounded-lg">

                  <input type="number" name="edu_year_start"
                     value="{{ old('edu_year_start', $latestEdu->year_start ?? '') }}"
                     placeholder="Année début" class="border p-2 rounded-lg">

                  <input type="number" name="edu_year_end"
                     value="{{ old('edu_year_end', $latestEdu->year_end ?? '') }}"
                     placeholder="Année fin" class="border p-2 rounded-lg">
               </div>
            </div>
            @endrole
            {{-- ===== RECRUTEUR SECTION ===== --}}
            @role('recruteur')
            <div class="mt-8 pt-8 border-t border-gray-100 space-y-4">
               <h3 class="text-xl font-bold text-indigo-600">Entreprise</h3>
               <input type="text" name="company_name" value="{{ $company->name ?? '' }}" class="w-full border border-gray-300 p-2.5 rounded-lg" placeholder="Nom entreprise">
               <textarea name="company_description" rows="4" class="w-full border border-gray-300 p-2.5 rounded-lg" placeholder="Description entreprise">{{ $company->description ?? '' }}</textarea>
            </div>
            @endrole

            <div class="pt-6">
               <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-200">
                  Enregistrer les modifications
               </button>
            </div>
      </form>
   </div>

   {{-- Password Update --}}
   <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Sécurité</h2>
      <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
         @csrf @method('PUT')
         <input type="password" name="current_password" placeholder="Ancien mot de passe" class="w-full border border-gray-300 p-2.5 rounded-lg">
         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="password" name="password" placeholder="Nouveau mot de passe" class="border border-gray-300 p-2.5 rounded-lg">
            <input type="password" name="password_confirmation" placeholder="Confirmation" class="border border-gray-300 p-2.5 rounded-lg">
         </div>
         <button class="bg-gray-800 hover:bg-black text-white px-6 py-2 rounded-lg font-semibold transition">
            Changer le mot de passe
         </button>
      </form>
   </div>
</div>
@endsection