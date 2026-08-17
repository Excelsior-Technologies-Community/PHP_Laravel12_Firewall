<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocked_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('url');
            $table->string('method', 10);
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocked_attempts');
    }
};