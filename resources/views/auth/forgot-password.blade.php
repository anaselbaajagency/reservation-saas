<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mot de passe oublié</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Mot de passe oublié</h1>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label class="block mb-2 font-medium" for="email">Email</label>
            <input type="email" name="email" id="email" required
                class="w-full p-2 mb-4 border rounded @error('email') border-red-500 @enderror" />
            @error('email')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button type="submit"
                class="w-full bg-yellow-600 text-white p-3 rounded hover:bg-yellow-700 transition">Envoyer lien de réinitialisation</button>
        </form>

        <p class="mt-4 text-center text-sm">
            Retour à la <a href="{{ route('login') }}" class="text-blue-600 hover:underline">connexion</a>
        </p>
    </div>
</body>
</html>
