<?php

namespace Tests\Feature\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
  use RefreshDatabase;

  public function test_search_word(): void
  {
    $user = User::factory()->create([
      'name' => 'テスト',
      'image' => 'test.jpg'
    ]);
    $category = Category::factory()->create();
    $post = Post::factory()->create([
      'user_id' => $user->id,
      'category_id' => $category->id,
    ]);

    $response = $this->actingAs($user, 'user')
      ->get(route('post.index', ['search_word' => 'テスト']));

    $response->assertStatus(200)
      ->assertJson([
        [
          'id' => $post->id,
          'user_id' => $post->user_id,
          'category_id' => $post->category_id,
          'content' => $post->content,
          'created_at' => $post->created_at->toJSON(),
          'updated_at' => $post->updated_at->toJSON(),
          'name' => $user->name,
          'image' => $user->image,
        ]
      ]);
  }

  public function test_category_id(): void
  {
    $user = User::factory()->create([
      'name' => 'テスト',
      'image' => 'test.jpg'
    ]);
    $category = Category::factory()->create();
    $post = Post::factory()->create([
      'user_id' => $user->id,
      'category_id' => $category->id,
    ]);

    $response = $this->actingAs($user, 'user')
      ->get(route('post.index', ['category_id' => $category->id]));

    $response->assertStatus(200)
      ->assertJson([
        [
          'id' => $post->id,
          'user_id' => $post->user_id,
          'category_id' => $post->category_id,
          'content' => $post->content,
          'created_at' => $post->created_at->toJSON(),
          'updated_at' => $post->updated_at->toJSON(),
          'name' => $user->name,
          'image' => $user->image,
        ]
      ]);
  }
}
