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
        Schema::disableForeignKeyConstraints();

        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('section', 255)->nullable();
            $table->string('order')->nullable();
            $table->string('name', 255)->nullable()->unique();
            $table->string('url', 255)->nullable();
            $table->string('banner', 255)->nullable();
            $table->string('alt', 255)->nullable();
            $table->string('quick_preview', 255)->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
