<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MemberPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_member_photo_is_stored_when_provided(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $tenant = Tenant::create(['name' => 'Église test', 'slug' => 'eglise-test', 'status' => 'active']);
        $user->tenants()->attach($tenant, ['role' => 'super_admin', 'status' => 'active']);

        $response = $this->actingAs($user)->post(route('members.store'), [
            'first_name' => 'Marie',
            'last_name' => 'Test',
            'status' => 'active',
            'photo' => UploadedFile::fake()->image('marie.jpg'),
        ]);

        $response->assertRedirect(route('members.index'));
        $member = $tenant->members()->firstOrFail();

        $this->assertNotNull($member->photo_path);
        Storage::disk('public')->assertExists($member->photo_path);
    }
}
