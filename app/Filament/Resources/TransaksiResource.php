<?php

namespace App\Filament\Resources;

use App\Level;
use Filament\Forms;
use App\Pengantaran;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
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
			Section::make('Informasi Umum')
            ->columns(2)
            ->schema([
				TextInput::make('nomor_nota')
                    ->label('ID Transaksi')
					->required()
                    ->readonly()
					->unique(ignoreRecord: true)
					->default(function () {
						// Get the current year and month
						$year = now()->format('Y');
						$month = now()->format('m');

						// Find the last transaction for the current month
						$lastTransaction = Transaksi::whereYear('created_at', $year)->whereMonth('created_at', $month)->latest()->first();
						$nextNumber = $lastTransaction ? (int) substr($lastTransaction->nomor_nota, -4) + 1 : 1;
						return "BJM-{$year}{$month}" . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);					}),
                Select::make('level_harga')
					->label('Level Harga')
					->options(Level::class)
					->live()
					->afterStateUpdated(function ($state, Set $set) {
						$set('pelanggan_id', null);
					})
					->required(),
                Forms\Components\Fieldset::make('')
                    ->schema([
                Forms\Components\TextInput::make('name')
                            ->label('Nama Pelanggan')
                            ->hidden(fn (Get $get): bool => $get('level_harga') !== 'ECER'),
                        
                      
				Select::make('pelanggan_id')
					->label('Pelanggan')
					->options(function (Get $get) { 				
						return \App\Models\Pelanggan::where('level_harga', $get('level_harga'))->pluck('nama', 'id');
					})
                    ->createOptionForm([
                                Forms\Components\TextInput::make('nama')
                                    ->required(),
                            ])
                            ->hidden(fn (Get $get): bool => $get('level_harga') === 'ECER')
                            ->required(),

                            Select::make('delivery')
                            ->label('Opsi Pengantaran')
                            ->options(Pengantaran::class)
                            ->required(),
                    ]),

                  

			]),

			Section::make('Detail Barang')->schema([
				Repeater::make('itemTransaksis')
					->relationship()
					->schema([
						Grid::make(4)
                        ->schema([
                            Select::make('nama_barang')
							->relationship('barang', 'nama')
							->label('Nama Barang')
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
					])
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
				EditAction::make(),
			])
			->bulkActions([
			
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
