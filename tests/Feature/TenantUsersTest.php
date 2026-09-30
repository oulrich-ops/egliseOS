<?php

namespace Tests\Feature;

use Tests\TestCase;

class TenantUsersTest extends TestCase
{
    public function test_tenant_user_management_requires_authentication(): void
    {
        $this->get('/settings/users')->assertRedirect('/login');
        $this->get('/settings/users/create')->assertRedirect('/login');
        $this->post('/settings/users', [])->assertRedirect('/login');
    }
}
