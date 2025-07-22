<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTransaksi extends Model
{
    protected $guarded = ['id'];
    
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
