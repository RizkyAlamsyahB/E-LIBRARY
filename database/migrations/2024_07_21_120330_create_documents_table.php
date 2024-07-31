<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->date('document_creation_date'); // Date of document creation
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('person_in_charge_id')->constrained('persons_in_charge')->onDelete('cascade');
            $table->foreignId('document_status_id')->nullable()->constrained('document_status')->onDelete('set null');
            $table->foreignId('classification_code_id')->nullable()->constrained('classification_codes')->onDelete('set null');
            $table->foreignId('subsection_id')->nullable()->constrained('subsections')->onDelete('set null');
            // Uncomment and adjust if needed
            // $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
