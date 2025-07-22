<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    dd($data);
    // Hitung total item transaksi
    $data['total'] = collect($data['itemTransaksis'] ?? [])->sum(function ($item) {
        return ($item['qty'] ?? 0) * ($item['harga_satuan'] ?? 0);
    });

    // Hitung total pembayaran
    $data['total_bayar'] = collect($data['pembayarans'] ?? [])->sum('jumlah');

    dd($data);

    // Hitung sisa piutang
    $data['sisa_piutang'] = $data['total'] - $data['total_bayar'];

    // Hitung jatuh tempo dari tanggal + termin
    $data['jatuh_tempo'] = \Carbon\Carbon::parse($data['tanggal'])
        ->addDays($data['termin'] ?? 0)
        ->toDateString();

    // Debug inspect data
    \Log::info('DATA TRANSAKSI', $data);
    // dd($data); // kamu bisa uncomment ini untuk debug langsung

    return $data;
}

}
