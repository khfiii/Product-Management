<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Model;

class HargaPelangganBarang extends Model
{
    protected $guarded = ['id'];

     public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
