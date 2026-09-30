<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_locale_choice_is_stored_in_the_session(): void
    {
        $this->get('/locale/en')
            ->assertRedirect()
            ->assertSessionHas('locale', 'en');
    }

    public function test_french_validation_messages_are_used(): void
    {
        $response = $this->withSession(['locale' => 'fr'])
            ->post('/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertStringContainsString('obligatoire', session('errors')->get('name')[0]);
    }
}
