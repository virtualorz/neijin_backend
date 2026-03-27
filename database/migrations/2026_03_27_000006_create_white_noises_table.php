<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('white_noises', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('名稱：雨聲/咖啡廳/海浪/森林鳥叫...');
            $table->json('audio')->comment('GCS 音頻 {"bucket","path","url"}');
            $table->json('icon')->nullable()->comment('GCS 圖示');
            $table->boolean('is_free')->default(false)->comment('免費版3-5種，付費版15-20種');
            $table->boolean('is_published')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('white_noises');
    }
};
