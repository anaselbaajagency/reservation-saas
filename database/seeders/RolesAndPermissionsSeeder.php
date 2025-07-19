<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function run(){
    // Reset cache
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Permissions pour votre SaaS de réservation
    $permissions = [
        // Gestion des réservations
        'view reservations',
        'create reservations',
        'edit reservations',
        'delete reservations',
        'approve reservations',
        
        // Gestion des utilisateurs
        'view users',
        'edit users',
        'delete users',
        
        // Administration
        'manage settings',
    ];

    foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
    }

    // Attribution des permissions aux rôles existants
    $superadmin = Role::findByName('superadmin');
    $superadmin->givePermissionTo(Permission::all());

    $admin = Role::findByName('admin');
    $admin->givePermissionTo([
        'view reservations',
        'create reservations',
        'edit reservations',
        'delete reservations',
        'approve reservations',
        'view users',
        'edit users',
    ]);

    $membre_validation = Role::findByName('membre_validation');
    $membre_validation->givePermissionTo([
        'view reservations',
        'approve reservations',
    ]);

    $expert = Role::findByName('expert');
    $expert->givePermissionTo([
        'view reservations',
        'create reservations',
        'edit reservations',
    ]);

    $client = Role::findByName('client');
    $client->givePermissionTo([
        'view reservations',
        'create reservations',
    ]);
}