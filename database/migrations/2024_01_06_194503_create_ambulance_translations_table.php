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
        Schema::create('ambulance_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('driver_name');
            $table->string('notes')->nullable();
            $table->unique(['ambulance_id','locale','driver_name']);
            $table->foreignId('ambulance_id')->references('id')->on('ambulances')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abmulance_translations');
    }
};
