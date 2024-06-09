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

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('agent_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title', 255)->nullable();
            $table->string('short_description', 255)->nullable();
            $table->string('person', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->boolean('is_featured')->nullable();
            $table->decimal('previous_price', 8, 2)->nullable();
            $table->decimal('current_price', 8, 2)->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->longText('description')->nullable();
            $table->string('location', 255)->nullable();
            $table->json('extra_field')->nullable();
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
        Schema::dropIfExists('offers');
    }
};
