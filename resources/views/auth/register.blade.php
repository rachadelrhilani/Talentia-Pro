@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center font-sans py-12">
    <div class="mb-8 text-center">
        <h1 class="text-3xl text-gray-900 mb-2">Tirez le meilleur parti de votre vie professionnelle</h1>
    </div>

    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-sm">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Nom complet</label>
                <input type="text" name="name" required
                    class="w-full border border-gray-400 p-2.5 rounded text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
                @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">E-mail</label>
                <input type="email" name="email" required
                    class="w-full border border-gray-400 p-2.5 rounded text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
                @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Mot de passe (6 caractères min.)</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-400 p-2.5 rounded text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-400 p-2.5 rounded text-black focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
            </div>

            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-1">Vous êtes ?</label>
                <select name="type" required
                    class="w-full border border-gray-400 p-2.5 rounded text-black bg-white focus:border-black focus:ring-1 focus:ring-black outline-none transition duration-200">
                    <option value="candidat">Chercheur d’emploi</option>
                    <option value="recruteur">Recruteur / Entreprise</option>
                </select>
            </div>

            <p class="text-xs text-gray-500 text-center mb-4">
                En cliquant sur Accepter et s’inscrire, vous acceptez les <span class="text-[#0a66c2] font-semibold cursor-pointer">Conditions d’utilisation</span> de Talentia.
            </p>

            <button type="submit" class="w-full bg-[#0a66c2] hover:bg-[#004182] text-white font-semibold py-3 rounded-full transition duration-200 text-lg">
                Accepter et s'inscrire
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-600">
                Déjà sur Talentia ? 
                <a href="{{ route('login') }}" class="text-[#0a66c2] hover:underline font-semibold">S'identifier</a>
            </p>
        </div>
    </div>
</div>
@endsection