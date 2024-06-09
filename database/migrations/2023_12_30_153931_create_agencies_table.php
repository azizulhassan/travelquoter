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

        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('agency_name', 255)->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('abn_acn', 255)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->boolean('do_you_operate_outside_australia')->nullable();
            $table->boolean('do_you_operate_through_your_website')->nullable();
            $table->text('business_description')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->json('services')->nullable();
            $table->string('street_address', 255)->nullable();
            $table->string('postcode', 10)->nullable();
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
        Schema::dropIfExists('agencies');
    }
};
