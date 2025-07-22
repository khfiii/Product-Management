<?php

use App\Models\Barang;
use App\Models\Pelanggan;
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
        Schema::create('harga_pelanggan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pelanggan::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Barang::class)->constrained()->onDelete('cascade');
            $table->integer('harga_override');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_pelanggan_barangs');
    }
};
