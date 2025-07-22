<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\TransaksiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Filament\Resources\TransaksiResource\Pages\EditTransaksi;
use App\Filament\Resources\TransaksiResource\Pages\ListTransaksis;
use App\Filament\Resources\TransaksiResource\Pages\CreateTransaksi;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        
        return $form->schema([
            Section::make('Informasi Umum')->schema([
                TextInput::make('nomor_nota')
                ->required(),
                BelongsToSelect::make('pelanggan_id')
                    ->label('Pelanggan')
                    ->relationship('pelanggan', 'nama')
                    ->required(),

                    Select::make('level_harga')
                        ->label('Level Harga')
                        ->options([
                            'P/Y/K' => 'P/Y',
                            'K' => 'KHUSUS',
                            'BESAR' => 'BESAR',
                            'T' => 'TOKO',
                            'E' => 'ECER',
                        ])
                        ->required(),
            ]),

            Section::make('Detail Barang')->schema([
               Repeater::make('item_transaksis')
                ->schema([
                    Select::make('nama_barang')
                        ->label('Nama Barang')
                        ->options(fn () => collect(Cache::get('harga_barang', []))->pluck('nama', 'nama')->toArray())
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                          
                        }),

                    TextInput::make('qty')
                        ->numeric()
                        ->default(1)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $set('subtotal', (float)$get('harga_satuan') * (int)$state);
                        }),

                    TextInput::make('harga_satuan')
                        ->numeric()
                        ->readOnly(),

                    TextInput::make('subtotal')
                        ->numeric()
                        ->readOnly(),
    ])
            ]),

            Section::make('Pembayaran')->schema([
                Repeater::make('pembayarans')
                    ->relationship()
                    ->label('Histori Pembayaran')
                    ->schema([
                        DatePicker::make('tanggal')->required(),
                        Select::make('metode')->options([
                            'tunai' => 'Tunai',
                            'transfer' => 'Transfer',
                        ])->required(),
                        TextInput::make('rekening')->label('Rekening (jika transfer)')->nullable(),
                        TextInput::make('jumlah')->numeric()->required(),
                    ])
                    ->defaultItems(1)
                    ->columns(4),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
