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
        Schema::table('cars', function (Blueprint $table) {
            $table->time('pick_up_time')->after('pick_up_datetime')->nullable();
            $table->time('drop_off_time')->after('drop_off_datetime')->nullable();
            $table->renameColumn('pick_up_datetime', 'pick_up_date');
            $table->renameColumn('drop_off_datetime', 'drop_off_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            //
        });
    }
};
