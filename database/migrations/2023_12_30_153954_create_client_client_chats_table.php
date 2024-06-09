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

        Schema::create('client_client_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->nullable()->constrained('clients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('to')->nullable()->constrained('clients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('attachment', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('message', 255)->nullable();
            $table->boolean('is_seen')->nullable();
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
        Schema::dropIfExists('client_client_chats');
    }
};
