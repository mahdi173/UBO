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
        Schema::table('wp_sites', function (Blueprint $table) {
            $table->unsignedBigInteger('pole_id')->default('0');
            $table->foreign('pole_id')->references('id')->on('poles')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('type_id')->default('0');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wp_sites', function (Blueprint $table) {
            //
        });
    }
};
