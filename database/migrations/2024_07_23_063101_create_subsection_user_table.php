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
        Schema::create('subsection_user', function (Blueprint $table) {
            $table->uuid('subsection_id');
            $table->uuid('user_id');

            // Set a composite primary key
            $table->primary(['subsection_id', 'user_id']);

            // Foreign keys with UUIDs
            $table->foreign('subsection_id')->references('id')->on('subsections')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsection_user');
    }
};
