<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_view_his_group()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/groups/{$group->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $group->id,
                    'user_id' => $user->id,
                    'name' => $group->name,
                    'description' => $group->description,
                ],
            ]);
    }

    /** @test */
    public function a_user_cant_view_a_group_he_doesnt_own()
    {
        $user = factory(User::class)->create();
        $owner = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $owner->id]);

        $response = $this->getJson("/api/groups/{$group->id}");

        $response->assertStatus(403)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /** @test */
    public function a_user_cant_view_a_group_that_doesnt_exist()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson('/api/groups/1000');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
