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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title'); // course title
            $table->text('description')->nullable(); // detailed course description
            $table->string('instructor')->nullable(); // name of the instructor
            $table->date('start_date'); // when the course starts
            $table->date('end_date')->nullable(); // optional: when it ends
            $table->string('location')->nullable(); // physical or virtual location
            $table->string('image')->nullable(); // course image
            $table->string('pdf')->nullable(); // course image
            $table->integer('slots')->default(0); // number of available slots
            $table->boolean('active')->default(true); // is the course visible/enabled
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
