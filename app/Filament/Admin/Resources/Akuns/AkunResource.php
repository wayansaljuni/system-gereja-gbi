<?php

namespace App\Filament\Admin\Resources\Akuns;

use App\Filament\Admin\Resources\Akuns\Pages\CreateAkun;
use App\Filament\Admin\Resources\Akuns\Pages\EditAkun;
use App\Filament\Admin\Resources\Akuns\Pages\ListAkuns;
use App\Filament\Admin\Resources\Akuns\Pages\ViewAkun;
use App\Filament\Admin\Resources\Akuns\Schemas\AkunForm;
use App\Filament\Admin\Resources\Akuns\Schemas\AkunInfolist;
use App\Filament\Admin\Resources\Akuns\Tables\AkunsTable;
use App\Models\Akun;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AkunResource extends Resource
{
    protected static ?string $model = Akun::class;
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedWallet;
    protected static ?string $navigationLabel = 'Akun Kas & Bank';
    protected static ?string $modelLabel = 'Akun';
    protected static ?string $pluralModelLabel = 'Akun Kas & Bank';
    protected static string|UnitEnum|null $navigationGroup ='Keuangan';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return AkunForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AkunInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AkunsTable::configure($table);
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
            'index' => ListAkuns::route('/'),
            'create' => CreateAkun::route('/create'),
            'view' => ViewAkun::route('/{record}'),
            'edit' => EditAkun::route('/{record}/edit'),
        ];
    }
}
