<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $user = [
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/authentication/register', $user);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['name' => $user['name'], 'email' => $user['email']]);
    }

    /** @test */
    public function a_user_has_to_confirm_password()
    {
        $user = [
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ];

        $response = $this->postJson('/api/authentication/register', $user);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['name' => $user['name'], 'email' => $user['email']]);
    }

    /** @test */
    public function a_user_has_to_enter_name()
    {
        $user = [
            'name' => '',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ];

        $response = $this->postJson('/api/authentication/register', $user);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['name' => $user['name'], 'email' => $user['email']]);
    }

    /** @test */
    public function a_user_has_to_enter_email()
    {
        $user = [
            'name' => '',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ];

        $response = $this->postJson('/api/authentication/register', $user);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['name' => $user['name'], 'email' => $user['email']]);
    }

    /** @test */
    public function a_user_has_to_enter_valid_email()
    {
        $user = [
            'name' => '',
            'email' => 'test@test',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ];

        $response = $this->postJson('/api/authentication/register', $user);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['name' => $user['name'], 'email' => $user['email']]);
    }

    /** @test */
    public function a_user_has_to_enter_unique_email()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $user = [
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/authentication/register', $user);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['name' => $user['name'], 'email' => $user['email']]);
    }
}
