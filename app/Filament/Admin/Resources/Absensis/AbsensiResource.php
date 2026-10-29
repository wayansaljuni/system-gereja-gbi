<?php

namespace App\Filament\Admin\Resources\Absensis;

use App\Filament\Admin\Resources\Absensis\Pages\CreateAbsensi;
use App\Filament\Admin\Resources\Absensis\Pages\EditAbsensi;
use App\Filament\Admin\Resources\Absensis\Pages\ListAbsensis;
use App\Filament\Admin\Resources\Absensis\Pages\ViewAbsensi;
use App\Filament\Admin\Resources\Absensis\Schemas\AbsensiForm;
use App\Filament\Admin\Resources\Absensis\Schemas\AbsensiInfolist;
use App\Filament\Admin\Resources\Absensis\Tables\AbsensisTable;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static string|UnitEnum|null $navigationGroup = 'Absensi';
    protected static ?string $navigationLabel = 'Absensi';
    protected static ?string $modelLabel = 'Absensi';
    protected static ?string $pluralModelLabel = 'Absensi';
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedClipboardDocumentCheck;

    public static function form(Schema $schema): Schema
    {
        return AbsensiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AbsensiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AbsensisTable::configure($table);
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
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
            'view' => ViewAbsensi::route('/{record}'),
            'edit' => EditAbsensi::route('/{record}/edit'),
        ];
    }
}
