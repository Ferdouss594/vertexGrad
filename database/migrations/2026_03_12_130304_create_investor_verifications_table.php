<?php
// database/migrations/2024_xx_xx_xxxxxx_create_investor_verifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_verifications', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('investor_id')->constrained('investors')->onDelete('cascade');
            
            // وثائق التحقق
            $table->string('id_document_path')->nullable(); // صورة الهوية
            $table->string('commercial_register_path')->nullable(); // السجل التجاري
            $table->string('bank_statement_path')->nullable(); // كشف حساب
            $table->string('additional_document_path')->nullable(); // وثيقة إضافية
            
            // حالة التحقق
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            
            // تواريخ
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            
            // من قام بالتحقق
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_verifications');
    }
};