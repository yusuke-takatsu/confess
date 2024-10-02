<?php

namespace Tests\Feature\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
  use RefreshDatabase;

  public function test_success(): void
  {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = $this->actingAs($user, 'user')
      ->delete(route('post.delete'), [
        'id' => $post->id,
      ]);

    $response->assertStatus(200)
      ->assertJson([
        'message' => '懺悔を削除しました。'
      ]);

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
  }

  public function test_not_found(): void
  {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user, 'user')
      ->delete(route('post.delete'), [
        'id' => 1,
      ]);

    $response->assertStatus(404)
      ->assertJson([
        'message' => '削除対象の懺悔が存在しません。'
      ]);
  }
}
