<?php

namespace Tests\Feature;

use Tests\TestCase;

class MemberDocumentsTest extends TestCase
{
    public function test_member_document_routes_require_authentication(): void
    {
        $this->get('/members/1/card')->assertRedirect('/login');
        $this->post('/members/1/recommendation')->assertRedirect('/login');
    }
}
