<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HargaBarangService
{
   
        public static function sync(): array
    {
        $sheetId = '1T5RGnRKdaf4CjijtTfvsakaG-6EgWRy--DHCOM9fdxw';
        $sheetName = 'DAFTAR HARGA';

        $response = Http::get("https://docs.google.com/spreadsheets/d/{$sheetId}/gviz/tq?tqx=out:json&sheet={$sheetName}");

        if ($response->failed()) {
            throw new \Exception('Gagal mengambil data dari Google Sheets.');
        }

        $raw = $response->body();
        $json = json_decode(substr($raw, 47, -2), true);

        $rows = $json['table']['rows'];
        $data = [];

        foreach ($rows as $row) {
            $nama = $row['c'][0]['v'] ?? null;
            if (!$nama) continue;

            $data[] = [
                'nama' => $nama,
                'PYK' => (float) str_replace(',', '', $row['c'][1]['v'] ?? 0),
                'KHUSUS' => (float) str_replace(',', '', $row['c'][2]['v'] ?? 0),
                'BESAR' => (float) str_replace(',', '', $row['c'][3]['v'] ?? 0),
                'TOKO' => (float) str_replace(',', '', $row['c'][4]['v'] ?? 0),
                'ECER' => (float) str_replace(',', '', $row['c'][5]['v'] ?? 0),
            ];
        }

        Cache::put('harga_barang', $data, now()->addHours(6));

        return $data;
    }


    public static function all(): array
    {
        return Cache::get('harga_barang', []);
    }
}
