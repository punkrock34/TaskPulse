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
    }

    public function testPasswordResetFormDisplaysError()
    {
        $response = $this->withSession(['error' => 'Invalid or expired reset code.'])
            ->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Invalid or expired reset code.');
    }
}
