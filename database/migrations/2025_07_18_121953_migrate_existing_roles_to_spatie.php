<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Spatie\Permission\Models\Role;

class MigrateExistingRolesToSpatie extends Migration
{
    public function up()
    {
        // Créer les rôles Spatie correspondants
        $roles = [
            'superadmin',
            'admin',
            'membre_validation', 
            'expert',
            'client'
        ];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        
        // Migrer les utilisateurs existants
        User::chunk(200, function ($users) {
            foreach ($users as $user) {
                if ($user->role) {
                    $user->assignRole($user->role);
                }
            }
        });
    }
    
    public function down()
    {
        // En cas de rollback, vous pouvez réinitialiser les rôles
        // Mais cela effacerait toutes les nouvelles permissions
        // À utiliser avec précaution
    }
}