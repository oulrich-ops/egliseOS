<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'eglise-centrale-ouaga'],
            [
                'name' => 'Église Centrale de Ouagadougou',
                'email' => 'contact@eglise-centrale.test',
                'phone' => '+226 00000000',
                'address' => 'Ouagadougou',
                'city' => 'Ouagadougou',
                'country' => 'Burkina Faso',
                'status' => 'active',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'admin@eglise.test'],
            [
                'name' => 'Administrateur',
                'password' => bcrypt('password'),
                'is_platform_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $user->forceFill(['is_platform_admin' => true, 'email_verified_at' => now()])->save();

        if (! $user->tenants()->where('tenant_id', $tenant->id)->exists()) {
            $user->tenants()->attach($tenant->id, ['role' => 'super_admin', 'status' => 'active']);
        }
    }
}
