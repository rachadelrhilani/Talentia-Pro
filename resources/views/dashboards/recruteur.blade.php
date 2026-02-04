@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard Recruteur</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <a href="{{ route('recruteur.jobs.index') }}" class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold text-lg">Mes Offres</h2>
        <p class="text-gray-500 mt-2">Gérer les offres publiées</p>
    </a>

    <a href="{{ route('recruteur.jobs.create') }}" class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold text-lg">Créer une offre</h2>
        <p class="text-gray-500 mt-2">Publier un nouveau poste</p>
    </a>

    <a href="{{ route('recruteur.company.edit') }}" class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold text-lg">Mon entreprise</h2>
        <p class="text-gray-500 mt-2">Modifier informations société</p>
    </a>

</div>

@endsection
