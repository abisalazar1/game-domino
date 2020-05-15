<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function user_can_create_a_game()
    {
        $user = \factory(User::class)->create();

        $user2 = \factory(User::class)->create();

        $this->actingAs($user, 'api');

        $response = $this->call('post', 'api/games', [
            'players' => [1, 2]
        ]);

        $response->assertStatus(201)->assertJson([
            'data' => [
                'id' => 1,
                'owner_id' => $user->id,
                'players_count' => 2,
                'turns' => []
            ]
        ]);
    }
}
