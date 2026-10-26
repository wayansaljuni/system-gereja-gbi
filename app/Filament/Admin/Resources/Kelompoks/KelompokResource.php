<?php

namespace App\Filament\Admin\Resources\Kelompoks;

// use App\Filament\Admin\Resources\Kelompoks\Pages\CreateKelompok;
// use App\Filament\Admin\Resources\Kelompoks\Pages\EditKelompok;
use App\Filament\Admin\Resources\Kelompoks\Pages\ListKelompoks;
use App\Filament\Admin\Resources\Kelompoks\Schemas\KelompokForm;
use App\Filament\Admin\Resources\Kelompoks\Tables\KelompoksTable;
use App\Models\Kelompok;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class KelompokResource extends Resource
{
    protected static ?string $model = Kelompok::class;

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-user-group';

    protected static string|UnitEnum|null $navigationGroup = 'Data Jemaat';

    protected static ?string $navigationLabel = 'KPW';

    protected static ?string $modelLabel = 'KPW';

    protected static ?string $pluralModelLabel = 'KPW';
    public static function form(Schema $schema): Schema
    {
        return KelompokForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KelompoksTable::configure($table);
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
            'index' => ListKelompoks::route('/'),
            // 'create' => CreateKelompok::route('/create'),
            // 'edit' => EditKelompok::route('/{record}/edit'),
        ];
    }
}
