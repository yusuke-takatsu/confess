<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('name')->comment('名前');
            $table->string('image')->nullable()->comment('名前');
            $table->timestamp('email_verified_at')->nullable()->comment('検証済み日');
            $table->string('password')->comment('パスワード');
            $table->boolean('is_guest')->default(false)->comment('ゲストユーザーか否か');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
