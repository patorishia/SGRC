<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Criar permissões
        $permissions = [
            //Admin:
            'create condominiums',
            'edit condominiums',
            'delete condominiums',
            'create complaint types',
            'edit complaint types',
            'delete complaint types',
            'create complaint statuses',
            'edit complaint statuses',
            'delete complaint statuses',
            'view statistics',
            'export reports',
            'send notifications',
            //User:
            'create complaints',
            'view own complaints',
            'view profile',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Criar roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Atribuir permissões ao admin
        $adminRole->givePermissionTo($permissions);

        // Atribuir permissões ao user
        $userRole->givePermissionTo(['create complaints', 'view own complaints', 'view profile']);

    }
}
