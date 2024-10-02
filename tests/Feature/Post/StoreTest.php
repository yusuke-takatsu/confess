<?php

namespace Tests\Feature\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
  use RefreshDatabase;

  public function test_success(): void
  {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user, 'user')
      ->post(route('post.store'), [
        'category_id' => $category->id,
        'content' => 'テスト',
      ]);

    $response->assertStatus(200)
      ->assertJson([
        'message' => '懺悔を登録しました。'
      ]);

    $this->assertDatabaseHas('posts', [
      'category_id' => $category->id,
      'content' => 'テスト',
    ]);
  }
}
