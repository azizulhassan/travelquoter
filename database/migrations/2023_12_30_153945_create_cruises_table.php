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

        Schema::create('cruises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('client_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('departure_port', 255)->nullable();
            $table->string('destination', 255)->nullable();
            $table->string('length_of_cruise', 255)->nullable();
            $table->dateTime('any_month_from')->nullable();
            $table->dateTime('any_month_to')->nullable();
            $table->string('no_of_travelers', 255)->nullable();
            $table->string('additional_info', 255)->nullable();
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
        Schema::dropIfExists('cruises');
    }
};
