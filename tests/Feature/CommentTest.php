<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_comment()
    {
        $user = User::factory()->createOne();
        $user = User::find($user->id);

        $response = $this->actingAs($user)->postJson('/api/comment/post', [
            'content' => 'Test Comment',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('comments', ['content' => 'Test Comment']);
    }

    public function test_get_all_comments()
    {
        Comment::factory(5)->create();

        $response = $this->getJson('/api/comment');

        $response->assertStatus(200)
                 ->assertJsonStructure(['success', 'comments' => ['data']]);
    }

    public function test_get_one_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->actingAs($comment->user)->getJson("/api/comment/{$comment->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);
    }

    public function test_update_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->actingAs($comment->user)->putJson("/api/comment/{$comment->id}", [
            'content' => 'Updated Comment',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('comments', ['content' => 'Updated Comment']);
    }

    public function test_delete_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->actingAs($comment->user)->deleteJson("/api/comment/{$comment->id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
