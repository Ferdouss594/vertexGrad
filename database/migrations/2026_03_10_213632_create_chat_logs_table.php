<?php
// database/migrations/2025_03_11_000000_create_chat_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->text('message');
            $table->text('response')->nullable();
            $table->integer('rating')->nullable();
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('created_at');
            $table->index('session_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_logs');
    }
};