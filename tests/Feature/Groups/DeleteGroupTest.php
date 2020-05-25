<?php

namespace Tests\Feature\Groups;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_delete_his_group()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('groups', ['id' => $group->id]);

        $response = $this->deleteJson("/api/groups/{$group->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
    }

    /** @test */
    public function a_user_cant_delete_a_group_he_doesnt_own()
    {
        $owner = factory(User::class)->create();
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $owner->id]);

        $this->assertDatabaseHas('groups', ['id' => $group->id]);

        $response = $this->deleteJson("/api/groups/{$group->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('groups', ['id' => $group->id]);
    }

    /** @test */
    public function a_user_cant_delete_inexistent_group()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson('/api/groups/1000');

        $response->assertStatus(404);
    }
}
