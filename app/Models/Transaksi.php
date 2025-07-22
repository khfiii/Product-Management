<?php

namespace App\Models;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\ItemTransaksi;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = ['id'];

        public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function itemTransaksis()
    {
        return $this->hasMany(ItemTransaksi::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    
}
