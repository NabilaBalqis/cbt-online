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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nip')->unique();
            $table->string('name');
            $table->string('address');
            // ->references('id')->on('classrooms')->cascadeOnDelete();
            $table->string('password');
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
