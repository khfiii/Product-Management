<?php

namespace App\Models;

use App\Models\Transaksi;
use App\Models\HargaPelangganBarang;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $guarded = ['id'];
    
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function hargaKhusus()
    {
        return $this->hasMany(HargaPelangganBarang::class);
    } 
}
