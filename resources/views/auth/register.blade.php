<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inscription</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Inscription</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label class="block mb-2 font-medium" for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                class="w-full p-2 mb-4 border rounded @error('nom') border-red-500 @enderror" />
            @error('nom')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <label class="block mb-2 font-medium" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full p-2 mb-4 border rounded @error('email') border-red-500 @enderror" />
            @error('email')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <label class="block mb-2 font-medium" for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required
                class="w-full p-2 mb-4 border rounded @error('password') border-red-500 @enderror" />
            @error('password')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            {{-- Choix rôle uniquement si inscription expert --}}
            <label class="block mb-2 font-medium" for="role">Rôle</label>
            <select name="role" id="role" class="w-full p-2 mb-4 border rounded">
                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                <option value="expert" {{ old('role') == 'expert' ? 'selected' : '' }}>Expert</option>
            </select>

            <button type="submit"
                class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 transition">S’inscrire</button>
        </form>

        <p class="mt-4 text-center text-sm">
            Déjà un compte ? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Connexion</a>
        </p>
    </div>
</body>
</html>