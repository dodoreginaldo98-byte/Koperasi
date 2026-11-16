<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_angsurans', function (Blueprint $table) {
            $table->decimal('pokok_dibayar', 15, 2)->default(0);
            $table->decimal('bunga_dibayar', 15, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_angsurans', function (Blueprint $table) {
            $table->dropColumn([
                'pokok_dibayar',
                'bunga_dibayar',
            ]);
        });
    }
};