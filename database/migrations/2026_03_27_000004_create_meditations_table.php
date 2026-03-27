<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meditations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->comment('冥想標題');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->comment('時長（分鐘）');
            $table->json('audio')->comment('GCS 音頻 {"bucket","path","url"}');
            $table->json('cover_image')->nullable()->comment('GCS 封面圖 {"bucket","path","url"}');
            $table->boolean('is_free')->default(false)->comment('是否免費');
            $table->boolean('is_published')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_free');
        });

        Schema::create('meditation_category', function (Blueprint $table) {
            $table->foreignId('meditation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meditation_category_id')->constrained()->cascadeOnDelete();
            $table->primary(['meditation_id', 'meditation_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meditation_category');
        Schema::dropIfExists('meditations');
    }
};
