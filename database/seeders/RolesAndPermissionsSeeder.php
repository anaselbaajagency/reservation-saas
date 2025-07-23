<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Création des permissions avec descriptions
        $permissions = [
            ['name' => 'reservation.create', 'description' => 'Créer une nouvelle réservation'],
            ['name' => 'reservation.view', 'description' => 'Voir les détails d’une réservation'],
            ['name' => 'reservation.edit', 'description' => 'Modifier une réservation'],
            ['name' => 'reservation.delete', 'description' => 'Supprimer une réservation'],
            ['name' => 'reservation.search.byName', 'description' => 'Rechercher une réservation par nom'],
            ['name' => 'reservation.search.byId', 'description' => 'Rechercher une réservation par ID'],
            ['name' => 'reservation.search.bySector', 'description' => 'Rechercher une réservation par secteur'],
            ['name' => 'reservation.search.byDomain', 'description' => 'Rechercher une réservation par domaine'],
            ['name' => 'reservation.approve', 'description' => 'Approve for validation'],


            ['name' => 'expert.create', 'description' => 'Ajouter un expert'],
            ['name' => 'expert.view', 'description' => 'Voir le profil d’un expert'],
            ['name' => 'expert.edit', 'description' => 'Modifier un profil expert'],
            ['name' => 'expert.delete', 'description' => 'Supprimer un expert'],
            ['name' => 'expert.search.byName', 'description' => 'Rechercher expert par nom'],
            ['name' => 'expert.search.byDomain', 'description' => 'Rechercher expert par domaine'],
            ['name' => 'expert.search.bySector', 'description' => 'Rechercher expert par secteur'],
            ['name' => 'expert.search.byId', 'description' => 'Rechercher expert par ID'],

            ['name' => 'client.create', 'description' => 'Créer un client'],
            ['name' => 'client.view', 'description' => 'Voir le profil d’un client'],
            ['name' => 'client.edit', 'description' => 'Modifier un client'],
            ['name' => 'client.delete', 'description' => 'Supprimer un client'],
            ['name' => 'client.search.byName', 'description' => 'Rechercher client par nom'],
            ['name' => 'client.search.byId', 'description' => 'Rechercher client par ID'],
            ['name' => 'client.validation.count', 'description' => 'Voir le nombre de validations d’un client'],

            ['name' => 'role.create', 'description' => 'Créer un rôle'],
            ['name' => 'role.view', 'description' => 'Voir la liste des rôles'],
            ['name' => 'role.edit', 'description' => 'Modifier un rôle'],
            ['name' => 'role.delete', 'description' => 'Supprimer un rôle'],
            ['name' => 'role.search.byName', 'description' => 'Rechercher rôle par nom'],
            ['name' => 'role.search.byId', 'description' => 'Rechercher rôle par ID'],

            ['name' => 'permission.create', 'description' => 'Créer une permission'],
            ['name' => 'permission.view', 'description' => 'Voir la liste des permissions'],
            ['name' => 'permission.edit', 'description' => 'Modifier une permission'],
            ['name' => 'permission.delete', 'description' => 'Supprimer une permission'],
            ['name' => 'permission.search.byName', 'description' => 'Rechercher permission par nom'],
            ['name' => 'permission.search.byId', 'description' => 'Rechercher permission par ID'],

            ['name' => 'user.create', 'description' => 'Créer un utilisateur'],
            ['name' => 'user.view', 'description' => 'Voir la liste des utilisateurs'],
            ['name' => 'user.edit', 'description' => 'Modifier un utilisateur'],
            ['name' => 'user.delete', 'description' => 'Supprimer un utilisateur'],
            ['name' => 'user.search.byName', 'description' => 'Rechercher utilisateur par nom'],
            ['name' => 'user.search.byId', 'description' => 'Rechercher utilisateur par ID'],

            ['name' => 'dashboard.access', 'description' => 'Accéder au tableau de bord'],
            ['name' => 'dashboard.stats.expert', 'description' => 'Voir les statistiques des experts'],
            ['name' => 'dashboard.stats.client', 'description' => 'Voir les statistiques des clients'],
            ['name' => 'dashboard.stats.reservation', 'description' => 'Voir les statistiques des réservations'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                ['name' => $permissionData['name']],
                ['description' => $permissionData['description']]
            );
        }

        // 2. Création des rôles s'ils n'existent pas
        $roles = [
            'superadmin' => 'Super Administrateur (accès complet)',
            'admin' => 'Administrateur',
            'membre_validation' => 'Membre de la validation',
            'expert' => 'Expert',
            'client' => 'Client'
        ];

        foreach ($roles as $name => $description) {
            Role::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }

        // 3. Attribution des permissions aux rôles
        $this->assignPermissions();
    }

    protected function assignPermissions()
    {
        // Superadmin - Toutes les permissions
        $superadmin = Role::findByName('superadmin');
        $superadmin->syncPermissions(Permission::all());

        // Admin
        $admin = Role::findByName('admin');
        $adminPermissions = [
            'reservation.create', 'reservation.view', 'reservation.edit', 'reservation.delete',
            'expert.view', 'client.view',
            'dashboard.access'
        ];
        $admin->syncPermissions($adminPermissions);

        // Membre Validation
        $membreValidation = Role::findByName('membre_validation');
        $membreValidation->syncPermissions([
            'reservation.view',
            'reservation.approve',
            'client.validation.count'
        ]);

        // Expert
        $expert = Role::findByName('expert');
        $expert->syncPermissions([
            'reservation.create',
            'reservation.view',
            'reservation.edit'
        ]);

        // Client
        $client = Role::findByName('client');
        $client->syncPermissions([
            'reservation.create',
            'reservation.view'
        ]);
    }
}