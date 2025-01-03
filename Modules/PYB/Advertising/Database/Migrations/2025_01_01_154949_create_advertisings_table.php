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
        Schema::create('advertisings', function (Blueprint $table) {
            $table->id();
            $table ->foreignIdFor(PYB\User\Models\User::class);
            $table->text('imagePath');
            $table->text('imageName');
            $table->string('link')->nullable();
            $table->string('title');
            $table->enum('location',\PYB\Advertising\Models\Advertising::$locations);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisings');
    }
};
