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
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->date('document_creation_date'); // Tanggal pembuatan dokumen
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('person_in_charge_id')->constrained('persons_in_charge')->onDelete('cascade');
            $table->foreignId('document_status_id')->constrained('document_status')->onDelete('cascade');
            $table->foreignId('classification_code_id')->nullable()->constrained('classification_codes')->onDelete('cascade'); // Kolom untuk kode klasifikasi
            $table->foreignId('subsection_id')->nullable()->constrained('subsections')->onDelete('cascade'); // Kolom untuk subseksi
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('cascade'); // Kolom untuk divisi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
