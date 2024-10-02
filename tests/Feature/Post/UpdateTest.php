<?php

namespace Tests\Feature\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
  use RefreshDatabase;

  public function test_success(): void
  {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'content' => '元々の内容'
    ]);

    $response = $this->actingAs($user, 'user')
      ->post(route('post.update'), [
        'id' => $post->id,
        'category_id' => $category->id,
        'content' => '更新後の内容',
      ]);

    $response->assertStatus(200)
      ->assertJson([
        'message' => '懺悔を更新しました。'
      ]);

    $this->assertDatabaseHas('posts', [
      'category_id' => $category->id,
      'content' => '更新後の内容',
    ]);
  }

  public function test_not_found(): void
  {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user, 'user')
      ->post(route('post.update'), [
        'id' => 1,
        'category_id' => $category->id,
        'content' => '更新後の内容',
      ]);

    $response->assertStatus(404)
      ->assertJson([
        'message' => '更新対象の懺悔が存在しません。'
      ]);
  }
}
