<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pelanggan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PelangganResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Filament\Resources\PelangganResource\Pages\EditPelanggan;
use App\Filament\Resources\PelangganResource\Pages\ListPelanggans;
use App\Filament\Resources\PelangganResource\Pages\CreatePelanggan;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(100),

                Select::make('level_harga')
                    ->label('Level Harga')
                    ->options([
                        'PY' => 'P/Y/K',
                        'K' => 'KHUSUS',
                        'B' => 'BESAR',
                        'T' => 'TOKO',
                        'E' => 'ECER',
                    ])
                    ->required()
                    ->searchable(),

                TextInput::make('termin')
                    ->label('Termin (Hari)')
                    ->numeric()
                    ->default(0)
                    ->helperText('Maksimal tempo pembayaran (dalam hari)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('level_harga')
                    ->label('Level')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'PY' => 'P/Y',
                        'K' => 'KHUSUS',
                        'B' => 'BESAR',
                        'T' => 'TOKO',
                        'E' => 'ECER',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('termin')->label('Termin')->suffix(' hari'),
                TextColumn::make('created_at')->label('Ditambahkan')->dateTime('d M Y')
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
            'index' => Pages\ListPelanggans::route('/'),
            // 'create' => Pages\CreatePelanggan::route('/create'),
            // 'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}
