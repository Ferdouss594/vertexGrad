<?php
// database/migrations/2024_xx_xx_xxxxxx_create_investment_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_requests', function (Blueprint $table) {
            $table->id();
            
            // ربط مع المستثمر
            $table->foreignId('investor_id')->constrained('investors')->onDelete('cascade');
            
            // رقم الطلب (فريد)
            $table->string('request_number')->unique();
            
            // المبلغ المطلوب
            $table->decimal('amount', 15, 2);
            
            // تفاصيل الطلب
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            
            // حالة الطلب
            $table->enum('status', [
                'pending', 
                'under_process', 
                'approved', 
                'rejected', 
                'cancelled'
            ])->default('pending');
            
            // تواريخ المعالجة
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            
            // من قام بالمعالجة
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            
            // سبب الرفض
            $table->text('rejection_reason')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_requests');
    }
};