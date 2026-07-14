<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_information', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('logo')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_information');
    }
};
