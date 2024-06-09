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

        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('cover', 255)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('token', 255)->nullable()->unique();
            $table->json('profession')->nullable();
            $table->double('total_earning')->default(0);
            $table->double('month_earning')->default(0);
            $table->integer('quote_completed')->default(0);
            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->rememberToken();
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
        Schema::dropIfExists('agents');
    }
};
