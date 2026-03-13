<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id')->index();
            $table->text('message');
            $table->text('response')->nullable();
            $table->string('intent')->nullable();
            $table->string('language')->nullable();
            $table->float('confidence')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('was_helpful')->nullable();
            $table->timestamps();
            
            // indexes for fast search
            $table->index(['user_id', 'created_at']);
            $table->index(['intent', 'confidence']);
        });

        Schema::create('chatbot_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->string('corrected_intent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_feedback');
        Schema::dropIfExists('conversations');
    }
};