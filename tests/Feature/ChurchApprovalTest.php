<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChurchApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_pending_church_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();
        $tenant = Tenant::create([
            'name' => 'Église en attente',
            'slug' => 'eglise-en-attente',
            'status' => 'pending',
        ]);
        $user->tenants()->attach($tenant, ['role' => 'super_admin', 'status' => 'pending']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('tenant.pending'));
    }

    public function test_only_platform_admin_can_approve_a_pending_church(): void
    {
        $admin = User::factory()->create(['is_platform_admin' => true]);
        $owner = User::factory()->create();
        $tenant = Tenant::create([
            'name' => 'Église à valider',
            'slug' => 'eglise-a-valider',
            'status' => 'pending',
        ]);
        $owner->tenants()->attach($tenant, ['role' => 'super_admin', 'status' => 'pending']);

        $this->actingAs($owner)
            ->patch(route('admin.tenants.approve', $tenant))
            ->assertForbidden();

        $this->actingAs($admin)
            ->patch(route('admin.tenants.approve', $tenant))
            ->assertRedirect(route('admin.tenants.index'));

        $this->assertDatabaseHas('tenants', ['id' => $tenant->id, 'status' => 'active']);
        $this->assertDatabaseHas('tenant_user', [
            'tenant_id' => $tenant->id,
            'user_id' => $owner->id,
            'status' => 'active',
        ]);
    }

    public function test_platform_admin_can_reject_a_pending_church(): void
    {
        $admin = User::factory()->create(['is_platform_admin' => true]);
        $tenant = Tenant::create([
            'name' => 'Église refusée',
            'slug' => 'eglise-refusee',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.tenants.reject', $tenant))
            ->assertRedirect(route('admin.tenants.index'));

        $this->assertDatabaseHas('tenants', ['id' => $tenant->id, 'status' => 'rejected']);
    }
}
