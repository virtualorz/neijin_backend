<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->unique()->comment('手機號碼（帳號）');
            $table->string('password');
            $table->string('name', 50)->nullable()->comment('暱稱');
            $table->json('avatar')->nullable()->comment('GCS 頭像 {"bucket","path","url"}');
            $table->enum('membership', ['free', 'premium'])->default('free')->comment('會員類型');
            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('daily_reminder')->default(false)->comment('每日提醒開關');
            $table->time('reminder_time')->nullable()->comment('提醒時間');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
