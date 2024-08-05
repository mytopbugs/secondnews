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
        Schema::create('news', function (Blueprint $table) {
            $table->id()->primary();
            $table->timestamp('create_time');
            $table->string('title')->index();
            $table->longText('preview')->index();
            $table->longText('content')->index();
            $table->string('preview_img');
            $table->string('content_img');
            $table->string('author');
            $table->string('recommend_list')->nullable();
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
