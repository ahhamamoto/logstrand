<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_get_his_profile()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'created_at', 'updated_at',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /** @test */
    public function a_user_cant_get_his_profile_without_token()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
}
