@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Recruteur</h1>

<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('recruteur.jobs.index') }}" class="card">Mes offres</a>
    <a href="{{ route('recruteur.jobs.create') }}" class="card">Créer une offre</a>
</div>
@endsection
