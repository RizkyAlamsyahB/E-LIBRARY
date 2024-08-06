<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('division_subsection', function (Blueprint $table) {
            $table->uuid('division_id');
            $table->uuid('subsection_id');

            // Set a composite primary key
            $table->primary(['division_id', 'subsection_id']);

            // Foreign keys with UUIDs
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('subsection_id')->references('id')->on('subsections')->onDelete('cascade');

            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('division_subsection');
    }
};
