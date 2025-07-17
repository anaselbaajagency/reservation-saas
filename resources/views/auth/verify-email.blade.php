<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            {{-- Logo de ton application --}}
            <x-authentication-card-logo />
        </x-slot>

        {{-- Message principal --}}
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous ne l’avez pas reçu, nous pouvons vous en renvoyer un.') }}
        </div>

        {{-- Message de succès après un renvoi --}}
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Un nouveau lien de vérification a été envoyé à l’adresse e-mail fournie.') }}
            </div>
        @endif

        {{-- Formulaires d'action --}}
        <div class="mt-4 flex items-center justify-between">
            {{-- Bouton pour renvoyer l’e-mail --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-button type="submit">
                    {{ __('Renvoyer l’e-mail de vérification') }}
                </x-button>
            </form>

            {{-- Liens pour profil ou déconnexion --}}
            <div>
                {{-- Lien vers le profil si nécessaire --}}
                @if (Route::has('profile.show'))
                    <a
                        href="{{ route('profile.show') }}"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ __('Modifier le profil') }}
                    </a>
                @endif

                {{-- Bouton de déconnexion --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button
                        type="submit"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2"
                    >
                        {{ __('Se déconnecter') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
