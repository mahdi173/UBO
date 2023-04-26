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
        Schema::table('user_site', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_user_id');
            $table->foreign('wp_user_id')->references('id')->on('wp_users')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('wp_site_id');
            $table->foreign('wp_site_id')->references('id')->on('wp_sites')->onDelete('restrict')->onUpdate('restrict');
            $table->softDeletes(); 
            $table->json("roles");
            $table->string("username");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_site', function (Blueprint $table) {
            //
        });
    }
};
