<?php

namespace Tests\Feature\Groups;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_create_a_group()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = [
            'name' => 'group name',
            'description' => 'group description',
        ];

        $response = $this->postJson('/api/groups', $group);

        $group['user_id'] = $user->id;

        $response->assertStatus(201);
        $this->assertDatabaseHas('groups', $group);
    }

    /** @test */
    public function a_user_cant_create_a_group_without_name()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = [
            'name' => '',
            'description' => 'group description',
        ];

        $response = $this->postJson('/api/groups', $group);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('groups', $group);
    }

    /** @test */
    public function a_user_cant_create_a_group_without_description()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = [
            'name' => 'group name',
            'description' => '',
        ];

        $response = $this->postJson('/api/groups', $group);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('groups', $group);
    }
}
