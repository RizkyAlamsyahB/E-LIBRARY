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
            $table->date('document_creation_date'); // Tanggal pembuatan dokumen
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('person_in_charge_id')->constrained('persons_in_charge')->onDelete('cascade');
            $table->foreignId('document_status_id')->nullable()->constrained('document_status')->onDelete('set null'); // Menggunakan 'set null' dan kolom diizinkan NULL
            $table->foreignId('classification_code_id')->nullable()->constrained('classification_codes')->onDelete('set null'); // Kolom untuk kode klasifikasi
            $table->foreignId('subsection_id')->nullable()->constrained('subsections')->onDelete('set null'); // Kolom untuk subsection
            // $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null'); // Kolom untuk divisi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
