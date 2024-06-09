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

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255)->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('budget', 255)->nullable();
            $table->boolean('receive_quote_via_call')->nullable();
            $table->boolean('receive_quote_via_email')->nullable();
            $table->boolean('receive_quote_via_sms')->nullable();
            $table->json('suitable_time')->nullable();
            $table->text('comment')->nullable();
            $table->string('status', 255)->nullable();
            $table->text('reason')->nullable();
            $table->string('file', 100)->nullable();
            $table->json('extra_field')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('quotes');
    }
};
