<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_user_can_be_created()
    {
        $response = $this->call('post', 'api/register', [
            "username" => "userOne",
            "password" => "password"
        ]);

        $this->assertDatabaseHas('users', ['username' => 'userOne']);

        $response->assertStatus(201)->assertJson([
            'data' => [
                'username' => 'userOne'
            ],
            'token' => [
                "token_type" => "Bearer"
            ]
        ]);
    }
}
