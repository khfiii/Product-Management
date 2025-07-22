<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Services\HargaBarangService;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TransaksiResource;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('syncHargaBarang')
            ->label('Sync Harga Barang')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function () {
                try {
                    $data = HargaBarangService::sync();

                    dd($data);
                    
                } catch (\Throwable $e) {
                    dd($e);
                    // filament()->notify('danger', 'Gagal sync: ' . $e->getMessage());
                }
            }),
        ];
    }
}
