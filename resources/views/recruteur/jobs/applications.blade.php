@extends('layouts.app')

@section('content')

<h1 class="text-xl font-bold mb-6">Candidatures reçues</h1>

@foreach($applications as $app)
<div class="bg-white p-4 rounded shadow mb-4">
    <p>{{ $app->candidate->name }}</p>
</div>
@endforeach

@endsection
