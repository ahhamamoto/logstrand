<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_login()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/authentication/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'created_at', 'updated_at', 'token',
            ],
        ]);
        $response->assertJson([
            'data' => collect($user)->except([
                'token', 'email_verified_at'
            ])->toArray(),
        ]);
    }

    /** @test */
    public function a_user_cant_login_with_wrong_password()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/authentication/login', ['email' => $user->email, 'password' => 'pass']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'error', 'message',
        ]);
        $response->assertJson([
            'error' => true,
        ]);
    }
}
