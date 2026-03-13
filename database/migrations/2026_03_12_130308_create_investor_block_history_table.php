<?php
// database/migrations/2024_xx_xx_xxxxxx_create_investor_block_history_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_block_history', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('investor_id')->constrained('investors')->onDelete('cascade');
            
            $table->enum('block_type', ['temporary', 'permanent']);
            $table->enum('action', ['blocked', 'unblocked']);
            
            $table->text('reason')->nullable();
            $table->timestamp('blocked_until')->nullable(); // للحظر المؤقت
            
            // من قام بالحظر/الفك
            $table->foreignId('performed_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_block_history');
    }
};