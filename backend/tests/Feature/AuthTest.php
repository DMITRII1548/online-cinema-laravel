<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        $this->withExceptionHandling();

        parent::setUp();
    }

    public function test_login_sucessful(): void 
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJson([
                'two_factor' => false,
            ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_if_user_already_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertForbidden();
    }

    public function test_logout_successful(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/api/logout');

        $response->assertOk()
            ->assertJson(['message' => 'Logout successful.']);

    }

    public function test_logout_if_user_not_authenticated(): void
    {
        $response = $this->post('/api/logout');

        $response->assertUnauthorized();
    }

    public function test_register_successful(): void
    {
        $user = User::factory()->make();

        $response = $this->post('/api/register', [
            'name' => $user->name, 
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk()
            ->assertJson(['message' => 'Registration successful.']);
    }
}