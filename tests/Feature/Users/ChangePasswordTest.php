<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_change_password()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->putJson('/api/users/change-password', [
            'password' => 'password',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
        ]);

        $user = $user->fresh();

        $response->assertStatus(200);
        $this->assertTrue(Hash::check('newpassword', $user->password));
        $this->assertFalse(Hash::check('password', $user->password));
    }

    /** @test */
    public function a_user_has_to_confirm_new_password()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->putJson('/api/users/change-password', [
            'password' => 'password',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'password',
        ]);

        $user = $user->fresh();

        $response->assertStatus(422);
        $this->assertFalse(Hash::check('newpassword', $user->password));
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /** @test */
    public function a_user_have_to_match_old_password()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->putJson('/api/users/change-password', [
            'password' => 'different_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

        $user = $user->fresh();

        $response->assertStatus(401);
        $this->assertFalse(Hash::check('newpassword', $user->password));
        $this->assertTrue(Hash::check('password', $user->password));
    }
}
