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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nota')->unique();
            $table->foreignId('pelanggan_id')->constrained()->onDelete('cascade');
            $table->string('delivery');
            $table->date('tanggal_transaksi');
            $table->date('jatuh_tempo')->nullable();
            $table->integer('total_transaksi')->default(0);
            $table->integer('total_bayar')->default(0);
            $table->integer('sisa_piutang')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
