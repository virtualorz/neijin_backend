<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sleep_stories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->comment('時長（分鐘）20-30');
            $table->json('audio')->comment('GCS 音頻 {"bucket","path","url"}');
            $table->json('cover_image')->nullable()->comment('GCS 封面圖');
            $table->json('background_music')->nullable()->comment('GCS 背景音樂');
            $table->boolean('is_published')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sleep_stories');
    }
};
