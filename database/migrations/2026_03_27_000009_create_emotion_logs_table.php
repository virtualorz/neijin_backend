<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emotion_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->comment('情緒分數 1-5');
            $table->date('logged_date')->comment('打卡日期');
            $table->text('note')->nullable()->comment('備註');
            $table->timestamps();

            $table->unique(['user_id', 'logged_date']);
            $table->index(['user_id', 'logged_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emotion_logs');
    }
};
