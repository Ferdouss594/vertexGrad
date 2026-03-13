<?php
// database/migrations/2024_xx_xx_xxxxxx_create_investor_interested_projects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_interested_projects', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('investor_id')->constrained('investors')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            
            $table->enum('interest_level', ['low', 'medium', 'high'])->default('medium');
            $table->text('notes')->nullable();
            $table->timestamp('last_viewed_at')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // منع تكرار نفس المشروع لنفس المستثمر
            $table->unique(['investor_id', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_interested_projects');
    }
};