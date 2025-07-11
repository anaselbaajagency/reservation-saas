<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Réinitialisation du mot de passe</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Réinitialisation du mot de passe</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label class="block mb-2 font-medium" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full p-2 mb-4 border rounded @error('email') border-red-500 @enderror" />
            @error('email')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <label class="block mb-2 font-medium" for="password">Nouveau mot de passe</label>
            <input type="password" name="password" id="password" required
                class="w-full p-2 mb-4 border rounded @error('password') border-red-500 @enderror" />
            @error('password')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <label class="block mb-2 font-medium" for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full p-2 mb-4 border rounded" />

            <button type="submit"
                class="w-full bg-purple-600 text-white p-3 rounded hover:bg-purple-700 transition">Réinitialiser</button>
        </form>
    </div>
</body>
</html>
