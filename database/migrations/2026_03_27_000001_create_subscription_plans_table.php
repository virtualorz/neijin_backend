<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('方案名稱：月訂閱/年訂閱/企業方案');
            $table->string('slug', 30)->unique()->comment('程式識別碼：monthly / yearly / enterprise');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->comment('計費週期');
            $table->unsignedInteger('price')->comment('價格（NT$）');
            $table->text('description')->nullable();
            $table->json('features')->nullable()->comment('方案功能列表 JSON');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
