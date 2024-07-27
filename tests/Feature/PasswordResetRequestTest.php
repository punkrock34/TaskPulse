<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testPasswordResetRequestPageLoads()
    {
        $response = $this->get(route('reset-password.request'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password.request');
    }

    public function testPasswordResetFormDisplaysError()
    {
        $response = $this->withSession(['error' => 'Invalid or expired reset code.'])
            ->get(route('reset-password.request').'/invalid-code');

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Invalid or expired reset code.');
    }

    public function testPasswordResetFormSubmitsSuccessfully()
    {
        $response = $this->post(route('reset-password.request'), [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }
}
