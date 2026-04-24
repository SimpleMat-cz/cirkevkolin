<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('youtube_id')->nullable()->unique();
            $table->string('audio_url')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->text('bible_references')->nullable();
            $table->text('study_questions')->nullable();
            $table->foreignId('speaker_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('series_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
