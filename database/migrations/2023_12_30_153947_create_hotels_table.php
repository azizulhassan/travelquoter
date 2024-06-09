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

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('client_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('desired_city', 255)->nullable();
            $table->string('check_in', 255)->nullable();
            $table->string('check_out', 255)->nullable();
            $table->string('trip_days')->nullable();
            $table->string('no_of_travelers', 255)->nullable();
            $table->string('accommodation_type', 255)->nullable();
            $table->string('room', 255)->nullable();
            $table->string('rating', 255)->nullable();
            $table->json('other', 255)->nullable();
            $table->json('options')->nullable();
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
        Schema::dropIfExists('hotels');
    }
};
