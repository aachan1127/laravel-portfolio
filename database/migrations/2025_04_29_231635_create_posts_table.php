<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // 投稿タイトル
            $table->text('description'); // 投稿説明文
            $table->string('image_path')->nullable(); // 画像ファイルの保存パス（後で使うから今から用意）
            $table->timestamps(); // created_at と updated_at を自動で作る
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
