<?php

namespace Tests\Feature\Groups;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_update_his_group()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $updatedGroup = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];

        $response = $this->putJson("/api/groups/{$group->id}", $updatedGroup);

        $response->assertStatus(200);
        $this->assertDatabaseHas('groups', $updatedGroup);
        $this->assertDatabaseMissing('groups', [
            'name' => $group->name,
            'description' => $group->description
        ]);
    }

    /** @test */
    public function a_user_cant_update_a_group_he_doesnt_own()
    {
        $user = factory(User::class)->create();
        $owner = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $owner->id]);

        $updatedGroup = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];

        $response = $this->putJson("/api/groups/{$group->id}", $updatedGroup);

        $response->assertStatus(403)
            ->assertJsonStructure([
                'message',
            ]);
        $this->assertDatabaseMissing('groups', $updatedGroup);
        $this->assertDatabaseHas('groups', [
            'name' => $group->name,
            'description' => $group->description
        ]);
    }

    /** @test */
    public function a_user_cant_update_a_group_that_doesnt_exist()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson('/api/groups/1000');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /** @test */
    public function a_user_cant_update_without_name_or_description_of_group()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $group = factory(Group::class)->create(['user_id' => $user->id]);

        $updatedGroup = [
            'name' => '',
            'description' => '',
        ];

        $response = $this->putJson("/api/groups/{$group->id}", $updatedGroup);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('groups', $updatedGroup);
        $this->assertDatabaseHas('groups', [
            'name' => $group->name,
            'description' => $group->description
        ]);
    }
}
