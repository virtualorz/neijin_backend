<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meditation_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('分類名稱：正念/感恩/慈悲心/睡前/通勤/壓力釋放');
            $table->string('slug', 30)->unique();
            $table->json('icon')->nullable()->comment('GCS 圖示 {"bucket","path","url"}');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meditation_categories');
    }
};
