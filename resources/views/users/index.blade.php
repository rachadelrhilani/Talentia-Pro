@extends('layouts.app')

@section('content')
@foreach($users as $user)

<a href="{{ route('users.show',$user) }}"
   class="block bg-white p-4 rounded shadow mb-3">

    <div class="flex items-center space-x-3">

        <img src="{{ $user->photo
            ? asset('storage/'.$user->photo)
            : 'https://ui-avatars.com/api/?name='.$user->name }}"
             class="w-12 h-12 rounded-full">

        <div>
            <h3 class="font-bold">{{ $user->name }}</h3>

            <p class="text-xs text-gray-500">
                {{ $user->hasRole('recruteur') ? 'Recruteur' : 'Candidat' }}
            </p>

            <p class="text-xs">
                {{ $user->profile->title ?? '' }}
            </p>
        </div>

    </div>

</a>

@endforeach
@endsection