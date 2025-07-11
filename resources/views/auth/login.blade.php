<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Connexion</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

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

            <button type="submit"
                class="w-full bg-green-600 text-white p-3 rounded hover:bg-green-700 transition">Se connecter</button>
        </form>

        <p class="mt-4 text-center text-sm">
            Mot de passe oublié ?
            <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Réinitialiser</a>
        </p>

        <p class="mt-2 text-center text-sm">
            Pas encore inscrit ?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">S’inscrire</a>
        </p>
    </div>
</body>
</html>
