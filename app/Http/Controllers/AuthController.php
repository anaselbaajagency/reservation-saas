<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 👀 Affiche le formulaire d'inscription
    public function showRegisterForm() {
        return view('auth.register');
    }

    // 📝 Enregistre l'utilisateur
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',              // au moins 8 caractere
                'regex:/[A-Z]/',      // au moins une majuscule
                'regex:/[a-z]/',      // au moins une minuscule
                'regex:/[0-9]/',      // au moins un chiffre
                'regex:/[@$!%*?&#]/'  // au moins un caractere spécial
                ],
            'role' => 'required|in:client,expert',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);
        return redirect()->route('verification.notice');
    }

    // 👀 Affiche le formulaire de login
    public function showLoginForm() {
        return view('auth.login');
    }

    // 🔐 Connecte l’utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect to role-specific dashboard
            if ($user->hasRole('superadmin')) {
                return redirect()->intended(route('superadmin.dashboard'));
            }
            
            if ($user->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            if ($user->hasRole('expert')) {
                return redirect()->intended(route('expert.dashboard'));
            }
            
            if ($user->hasRole('client')) {
                return redirect()->intended(route('client.dashboard'));
            }
            
            // Fallback to general dashboard
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Identifiants incorrects.',
        ]);
    }

    // 🚪 Déconnexion
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // 👀 Formulaire mot de passe oublié
    public function showForgotPasswordForm() {
        return view('auth.forgot-password');
    }

    // 📧 Envoi lien reset
    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // 👀 Affiche formulaire reset
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
    ]);
    }

    // 🔁 Réinitialise le mot de passe
    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
