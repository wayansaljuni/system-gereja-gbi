<?php

namespace App\Filament\Admin\Resources\KategoriKeuangans;

use App\Filament\Admin\Resources\KategoriKeuangans\Pages\CreateKategoriKeuangan;
use App\Filament\Admin\Resources\KategoriKeuangans\Pages\EditKategoriKeuangan;
use App\Filament\Admin\Resources\KategoriKeuangans\Pages\ListKategoriKeuangans;
use App\Filament\Admin\Resources\KategoriKeuangans\Pages\ViewKategoriKeuangan;
use App\Filament\Admin\Resources\KategoriKeuangans\Schemas\KategoriKeuanganForm;
use App\Filament\Admin\Resources\KategoriKeuangans\Schemas\KategoriKeuanganInfolist;
use App\Filament\Admin\Resources\KategoriKeuangans\Tables\KategoriKeuangansTable;
use App\Models\KategoriKeuangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KategoriKeuanganResource extends Resource
{
    protected static ?string $model = KategoriKeuangan::class;
    protected static ?string $recordTitleAttribute = 'KategoriKeuangan';
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Kategori Keuangan';
    protected static ?string $modelLabel = 'Kategori Keuangan';
    protected static ?string $pluralModelLabel = 'Kategori Keuangan';
    protected static string|UnitEnum|null $navigationGroup ='Keuangan';
    protected static ?int $navigationSort = 2;    

    public static function form(Schema $schema): Schema
    {
        return KategoriKeuanganForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KategoriKeuanganInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriKeuangansTable::configure($table);
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
            'index' => ListKategoriKeuangans::route('/'),
            'create' => CreateKategoriKeuangan::route('/create'),
            'view' => ViewKategoriKeuangan::route('/{record}'),
            'edit' => EditKategoriKeuangan::route('/{record}/edit'),
        ];
    }
}
