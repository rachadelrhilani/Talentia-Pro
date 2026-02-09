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
                @error('email')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
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