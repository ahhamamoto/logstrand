<?php

namespace Tests\Feature\Groups;

use App\Http\Resources\Api\Groups\GroupCollection;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewAllTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_view_all_his_groups()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user, ['*']);

        $groups = factory(Group::class, 5)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/groups');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $response->assertJson(['data' => (new GroupCollection($groups->load('user')))->toArray($response)]);
    }
}
