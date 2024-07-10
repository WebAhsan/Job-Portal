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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('job_category');
            $table->string('job_nature');
            $table->integer('vacancy');
            $table->string('salary');
            $table->string('location');
            $table->string('description');
            $table->string('benefits');
            $table->string('responsibility');
            $table->string('qualification');
            $table->string('keywords');
            $table->string('company_name');
            $table->string('company_location');
            $table->string('company_website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
