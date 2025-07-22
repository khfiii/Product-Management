<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                ->label('Nama Barang')
                ->required(), 
                TextInput::make('harga_py')
                ->required() 
                ->label('Harga PYK'), 
                TextInput::make('harga_k')
                ->required()
                ->label('Harga Khusus'), 
                TextInput::make('harga_b')
                ->required()
                ->label('Harga Besar'), 
                TextInput::make('harga_t')
                ->required()
                ->label('Harga Toko'), 
                TextInput::make('harga_e')
                ->required()
                ->label('Harga Ecer'), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                ->label('Nama Barang')
                ->searchable(), 
                TextColumn::make('harga_py')
                ->label('PYK')
                ->numeric(decimalPlaces: 0), 
                TextColumn::make('harga_k')
                ->numeric(decimalPlaces: 0)
                ->label('KHUSUS'), 
                TextColumn::make('harga_b')
                ->numeric(decimalPlaces: 0)
                ->label('BESAR'), 
                TextColumn::make('harga_t')
                ->numeric(decimalPlaces: 0) 
                ->label('KECIL'), 
                TextColumn::make('harga_e')
                ->numeric(decimalPlaces: 0) 
                ->label('ECER'), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBarangs::route('/'),
            // 'create' => Pages\CreateBarang::route('/create'),
            // 'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
