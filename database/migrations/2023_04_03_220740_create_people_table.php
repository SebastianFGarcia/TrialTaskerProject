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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('nit')->unique();
            $table->date('issue_nit')->nullable();
            $table->string('num_ministry')->nullable();
            $table->string('num_dispach')->nullable();
            $table->string('radicated')->nullable();
            $table->string('authority')->nullable();
            $table->string('number')->nullable();
            $table->foreignId('type_people_id')->constrained('type_people')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
