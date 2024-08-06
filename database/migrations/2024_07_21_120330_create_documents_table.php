<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID as primary key
            $table->string('number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->date('document_creation_date'); // Date of document creation
            // Foreign keys dengan UUID
            $table->uuid('uploaded_by')->nullable();
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');

            $table->uuid('person_in_charge_id')->nullable();
            $table->foreign('person_in_charge_id')->references('id')->on('persons_in_charge')->onDelete('set null');

            $table->uuid('document_status_id')->nullable();
            $table->foreign('document_status_id')->references('id')->on('document_status')->onDelete('set null');

            $table->uuid('classification_code_id')->nullable();
            $table->foreign('classification_code_id')->references('id')->on('classification_codes')->onDelete('set null');

            $table->uuid('subsection_id')->nullable();
            $table->foreign('subsection_id')->references('id')->on('subsections')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
