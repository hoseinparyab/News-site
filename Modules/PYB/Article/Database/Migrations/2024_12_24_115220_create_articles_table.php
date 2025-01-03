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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('time_to_read');
            $table->string('imageName');
            $table->string('imagePath');
            $table->string('score')->default(0);
            $table->string('Keywords')->nullable();
            $table->string('description')->nullable();
            $table->longText('body');
            $table->enum('status',\PYB\Article\Models\Article::$statuses);
            $table->enum('type', \PYB\Article\Models\Article::$types)->default(\PYB\Article\Models\Article::TYPE_NORMAL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
