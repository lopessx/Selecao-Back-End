<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $response = $this->postJson('/api/user', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    }

    public function test_get_user_by_id()
    {
        $user = User::factory()->create();
        $user = User::find($user->id);

        $response = $this->actingAs($user)->getJson("/api/user/{$user->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true, 'email' => $user->email]);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $user = User::find($user->id);

        $response = $this->actingAs($user)->putJson("/api/user/{$user->id}", [
            'name' => 'Updated User',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['name' => 'Updated User']);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $user = User::find($user->id);

        $response = $this->actingAs($user)->deleteJson("/api/user/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
