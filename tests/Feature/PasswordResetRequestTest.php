<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testPasswordResetRequestPageLoads()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        // Since you're using Vue, there's no view to check.
    }

    public function testPasswordResetFormDisplaysError()
    {
        $response = $this->withSession(['error' => 'Invalid or expired reset code.'])
            ->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Invalid or expired reset code.');
    }

    public function testPasswordResetFormSubmitsSuccessfully()
    {
        // Assuming you have a user in the database to test with.
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->postJson('/api/password-reset', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Password reset link sent to your email']);
    }
}
