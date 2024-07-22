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
            $table->date('year'); // Tahun pembuatan dokumen
            $table->string('code')->unique(); // Kode dokumen
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('person_in_charge_id')->constrained('persons_in_charge')->onDelete('cascade');
            $table->foreignId('document_status_id')->constrained('document_status')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
