<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\IndexRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
  public function index(IndexRequest $request)
  {
    // リクエストからパラメータを取得
    $searchWord = $request->input('search_word');
    $categoryId = $request->input('category_id');
    $sortBy = $request->input('sort_by');
    $sortType = $request->input('sort_type');

    $query = Post::select('posts.*', 'users.name', 'users.image')
      ->join('users', 'posts.user_id', '=', 'users.id');

    // search_wordが存在する場合の条件追加
    if ($searchWord) {
      $query->where(function ($q) use ($searchWord) {
        $q->where('users.name', 'like', '%' . $searchWord . '%')
          ->orWhere('posts.content', 'like', '%' . $searchWord . '%');
      });
    }

    // category_idが存在する場合の条件追加
    if ($categoryId) {
      $query->where('posts.category_id', $categoryId);
    }

    // ソート条件の適用
    if ($sortBy && $sortType) {
      $query->orderBy($sortBy, $sortType);
    }

    // get()で実際にデータを取得
    $posts = $query->get();

    return response()->json($posts);
  }

  public function store(StoreRequest $request)
  {
      $user = Auth::user();

      Post::create([
          'user_id' => $user->id,
          'category_id' => $request->input('category_id'),
          'content' => $request->input('content'),
      ]);

      return response()->json([
          'message' => '懺悔を登録しました。',
      ]);
  }

  public function update(UpdateRequest $request)
  {
      $user = Auth::user();
      $post = Post::where('user_id', $user->id)->find($request->input('id'));

      if (is_null($post)) {
        return response()->json([
            'message' => '更新対象の懺悔が存在しません。',
        ], 404);
      }

      $post->update([
          'category_id' => $request->input('category_id'),
          'content' => $request->input('content'),
      ]);

      return response()->json([
          'message' => '懺悔を更新しました。',
      ]);
  }
}
