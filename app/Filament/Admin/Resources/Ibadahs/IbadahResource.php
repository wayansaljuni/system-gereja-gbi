<?php

namespace App\Filament\Admin\Resources\Ibadahs;

use App\Filament\Admin\Resources\Ibadahs\Pages\ListIbadahs;
use App\Filament\Admin\Resources\Ibadahs\Pages\ViewIbadah;
use App\Filament\Admin\Resources\Ibadahs\Schemas\IbadahForm;
use App\Filament\Admin\Resources\Ibadahs\Schemas\IbadahInfolist;
use App\Filament\Admin\Resources\Ibadahs\Tables\IbadahsTable;
use App\Models\Ibadah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class IbadahResource extends Resource
{
    protected static ?string $model = Ibadah::class;
    protected static ?string $navigationLabel = 'Ibadah';
    protected static ?string $modelLabel = 'Ibadah';
    protected static ?string $pluralModelLabel = 'Ibadah';
    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-building-library';
    protected static string|UnitEnum|null $navigationGroup =
        'Data Jemaat';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?int $navigationSort = 5;    


    public static function form(Schema $schema): Schema
    {
        return IbadahForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IbadahInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IbadahsTable::configure($table);
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
            'index' => ListIbadahs::route('/'),
            // 'create' => CreateIbadah::route('/create'),
            'view' => ViewIbadah::route('/{record}'),
            // 'edit' => EditIbadah::route('/{record}/edit'),
        ];
    }
}
