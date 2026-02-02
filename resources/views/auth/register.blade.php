@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Sign up</h2>

    <form method="POST">
        @csrf

        <input name="name" placeholder="Name" class="input">
        <input name="email" placeholder="Email" class="input">
        <input type="password" name="password" placeholder="Password" class="input">
        <input type="password" name="password_confirmation" placeholder="Confirm" class="input">

        <select name="type" class="w-full border p-2 mb-3 rounded">
            <option value="candidat">Chercheur d’emploi</option>
            <option value="recruteur">Recruteur</option>
        </select>

        <button class="w-full bg-blue-600 text-white py-2 rounded">
            Créer un compte
        </button>
    </form>
</div>
@endsection
