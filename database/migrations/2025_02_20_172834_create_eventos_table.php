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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string("image_path")->nullable();
            $table->dateTime("date");
            $table->string("name");
            $table->string("owner");
            $table->string("city");
            $table->string("state", 2);
            $table->string("address");
            $table->unsignedInteger("number");
            $table->string("complement")->nullable();
            $table->string("phone", 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
