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
        Schema::create('news', static function (Blueprint $table) {
            $table->id();
            $table->string('title', 10000);
            $table->string('description', 100000);
            $table->string('url');
            $table->json('title_trigram')->nullable();
            $table->json('description_trigram')->nullable();
            $table->timestamps();

            $table->index('url', 'idx_news_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
