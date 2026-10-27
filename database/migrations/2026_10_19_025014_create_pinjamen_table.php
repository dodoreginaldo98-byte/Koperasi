<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            
            // Gunakan foreignId agar tipe data otomatis menyesuaikan (unsignedBigInteger)
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            
            // Kolom-kolom lainnya untuk tabel pinjaman...
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->date('tanggal_pinjaman');
            $table->enum('status', ['pending', 'disetujui', 'lunas'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};