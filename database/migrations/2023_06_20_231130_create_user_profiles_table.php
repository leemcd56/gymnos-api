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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('avatar_id')
                ->nullable()
                ->references('id')
                ->on('files')
                ->nullOnDelete();
            $table->foreignId('cover_id')
                ->nullable()
                ->references('id')
                ->on('files')
                ->nullOnDelete();
            $table->string('tagline')->nullable();
            $table->string('gender')->nullable();
            $table->string('discord')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('github')->nullable();
            $table->string('naturist_hub')->nullable();
            $table->text('bio')->nullable();
            $table->date('date_of_birth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
