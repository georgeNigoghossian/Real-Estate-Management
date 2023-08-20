<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    /**
     * @test
     */
    public function it_can_update_user_account_with_valid_data()
    {
        $faker = Factory::create();

        $user = Factory::create('App\Models\User');
        $request = [
            'name' => $faker->name,
            'email' => $faker->email,
        ];

        $response = $this->patchJson('/api/users/' . $user->id, $request);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'User account updated successfully']);
        $user->refresh();
        $this->assertEquals($request['name'], $user->name);
        $this->assertEquals($request['email'], $user->email);
    }

    /**
     * @test
     */
    public function it_fails_to_update_user_account_with_invalid_data()
    {
        $user = Factory::create('App\Models\User');
        $request = [
            'name' => '',
            'email' => 'invalid_email',
        ];

        $response = $this->patchJson('/api/users/' . $user->id, $request);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['name', 'email']);
    }
}
