@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Candidat</h1>

<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('profile.show') }}" class="card">Mon CV</a>
    <a href="{{ route('candidat.jobs.index') }}" class="card">Rechercher des offres</a>
    <a href="{{ route('candidat.friends') }}" class="card">Mes amis</a>
</div>
@endsection
