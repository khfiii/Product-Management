<?php

namespace App\Models;

use App\Models\ItemTransaksi;
use App\Models\HargaPelangganBarang;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = ['id'];

     public function itemTransaksi()
    {
        return $this->hasMany(ItemTransaksi::class);
    }

    public function hargaKhusus()
    {
        return $this->hasMany(HargaPelangganBarang::class);
    }
}
