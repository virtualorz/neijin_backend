<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breathing_patterns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('名稱：4-7-8 / Box Breathing / 基礎 2-4');
            $table->unsignedTinyInteger('inhale_seconds')->comment('吸氣秒數');
            $table->unsignedTinyInteger('hold_seconds')->default(0)->comment('屏息秒數');
            $table->unsignedTinyInteger('exhale_seconds')->comment('吐氣秒數');
            $table->unsignedTinyInteger('hold_after_exhale_seconds')->default(0)->comment('吐氣後屏息秒數');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breathing_patterns');
    }
};
