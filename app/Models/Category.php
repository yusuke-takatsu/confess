<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const CATEGORY_NAMES = [
        '職場',
        '恋愛',
        '家族'
    ];

    protected $guarded = [
      'id',
      'created_at',
      'updated_at',
  ];

  public function posts()
  {
      return $this->hasMany(Post::class);
  }
}
