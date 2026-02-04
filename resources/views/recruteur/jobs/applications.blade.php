@extends('layouts.app')

@section('content')

<h1 class="text-xl font-bold mb-6">Candidatures reçues</h1>

@foreach($applications as $app)
<div class="bg-white p-4 rounded shadow mb-4 flex justify-between items-center">

    <div>
        <p class="font-semibold">{{ $app->candidate->name }}</p>
        <span class="text-xs text-gray-500">
            Statut : {{ $app->status }}
        </span>
    </div>

    @if($app->status === 'pending')
    <div class="flex gap-2">

        <form action="{{ route('recruteur.applications.update',$app->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="accepted">
            <button class="bg-green-500 text-white px-3 py-1 rounded text-xs">
                Accepter
            </button>
        </form>

        <form action="{{ route('recruteur.applications.update',$app->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="rejected">
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                Refuser
            </button>
        </form>

    </div>
    @endif

</div>
@endforeach

@endsection
