<?php

namespace Tests\Feature;

use Tests\TestCase;

class MemberExportsTest extends TestCase
{
    public function test_member_exports_require_authentication(): void
    {
        $this->get('/members/export')->assertRedirect('/login');
        $this->get('/members/export.csv')->assertRedirect('/login');
    }
}
