<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_meditation_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->nullableMorphs('playable'); // meditation / sleep_story / course_lesson
            $table->unsignedSmallInteger('duration_seconds')->nullable()->comment('實際播放秒數');
            $table->boolean('completed')->default(false)->comment('是否播放完畢');
            $table->date('played_date')->comment('播放日期');
            $table->timestamps();

            $table->index(['user_id', 'played_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_meditation_history');
    }
};
