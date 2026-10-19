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
    Schema::create('angsuran', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pinjaman_id')->constrained('pinjaman')->onDelete('cascade');
        $table->date('tanggal_angsuran');
        $table->integer('jumlah_bayar');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};
