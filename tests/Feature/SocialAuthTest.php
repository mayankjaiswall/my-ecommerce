<?php

namespace Tests\Feature;

use Tests\TestCase;

class SocialAuthTest extends TestCase
{
    public function test_social_login_requires_an_access_token(): void
    {
        $this->postJson('/api/auth/social/google')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('access_token');
    }

    public function test_social_login_rejects_unsupported_providers(): void
    {
        $this->postJson('/api/auth/social/apple', ['access_token' => 'provider-token'])
            ->assertNotFound();
    }
}