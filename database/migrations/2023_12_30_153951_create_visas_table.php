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

        Schema::create('visas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('client_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('country_of_passport', 255)->nullable();
            $table->string('country_to_visit', 255)->nullable();
            $table->foreignId('passport_type_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('pick_up_date')->nullable();
            $table->date('drop_off_date')->nullable();
            $table->string('no_of_travelers', 255)->nullable();
            $table->foreignId('visit_purpose_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('no_of_visit', 255)->nullable();
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
        Schema::dropIfExists('visas');
    }
};
