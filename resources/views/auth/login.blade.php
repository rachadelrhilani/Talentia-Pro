@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center font-sans">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-sm">
        <div class="mb-6">
            <h2 class="text-3xl font-semibold text-gray-900">S'identifier</h2>
            <p class="text-sm text-gray-600 mt-2">Restez informé de votre monde professionnel</p>
        </div>

        <form method="POST" action="{{ route('loginForm') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1" for="email">E-mail ou téléphone</label>
                <input type="email" name="email" id="email" required
                    class="w-full border border-gray-400 p-3 rounded text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
                @if($errors->has('email'))
                <div class="flex items-center p-4 mb-4 text-red-800 rounded-2xl bg-red-50 border border-red-100 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-bold">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                @endif
            </div>

            <div class="mb-2">
                <label class="block text-sm text-gray-600 mb-1" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required
                    class="w-full border border-gray-400 p-3 rounded text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
            </div>

            <div class="mb-6">
                <a href="#" class="text-[#0a66c2] hover:underline font-semibold text-sm">Mot de passe oublié ?</a>
            </div>

            <button class="w-full bg-[#0a66c2] hover:bg-[#004182] text-white font-semibold py-3 rounded-full transition duration-200 text-lg">
                S'identifier
            </button>
        </form>

        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-3 text-gray-500 text-sm">ou</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <div class="text-center">
            <p class="text-gray-600">
                Nouvel utilisateur sur Talentia ?
                <a href="{{ route('registerForm') }}" class="text-[#0a66c2] hover:underline font-semibold">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection