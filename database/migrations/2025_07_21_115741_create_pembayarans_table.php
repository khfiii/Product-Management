<?php

use App\Models\Transaksi;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Transaksi::class)->constrained()->onDelete('cascade');
            $table->date('tanggal_bayar');
            $table->integer('jumlah_bayar');
            $table->string('metode_bayar'); // Tunai, Transfer BCA, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
