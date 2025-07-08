# Reservation-SaaS

Un système de réservation en ligne développé avec Laravel + Vite.

## 🔧 Fonctionnalités principales

- Authentification (client, expert, admin)
- Dashboard pour chaque rôle
- Gestion des rendez-vous
- Pages publiques : Accueil, Experts, Réservation
- Interface responsive

## 🛠️ Stack technique

- Laravel 11
- Vite + TailwindCSS
- MySQL
- GitHub / GitFlow

## 🚀 Démarrage local

```bash
git clone https://github.com/username/reservation-saas.git
cd reservation-saas
composer install
cp .env.example .env
php artisan key:generate
npm install && npm run dev
php artisan serve
