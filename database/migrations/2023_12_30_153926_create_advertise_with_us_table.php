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

        Schema::create('advertise_with_us', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('message', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('advertise_with_us');
    }
};
