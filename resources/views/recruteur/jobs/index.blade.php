@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Tableau de bord des offres</h1>
                <p class="text-gray-500 mt-1">Gérez vos annonces et suivez les candidatures reçues.</p>
            </div>
            <a href="{{ route('recruteur.jobs.create') }}"
               class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 shadow-lg shadow-indigo-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle Offre
            </a>
        </div>


        <div class="grid grid-cols-1 gap-4">
          <livewire:job-dashboard />  
        </div>
@endsection