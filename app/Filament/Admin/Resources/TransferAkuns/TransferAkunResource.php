<?php

namespace App\Filament\Admin\Resources\TransferAkuns;

use App\Filament\Admin\Resources\TransferAkuns\Pages\EditTransferAkun;
use App\Filament\Admin\Resources\TransferAkuns\Pages\ListTransferAkuns;
use App\Filament\Admin\Resources\TransferAkuns\Pages\ViewTransferAkun;
use App\Filament\Admin\Resources\TransferAkuns\Schemas\TransferAkunForm;
use App\Filament\Admin\Resources\TransferAkuns\Schemas\TransferAkunInfolist;
use App\Filament\Admin\Resources\TransferAkuns\Tables\TransferAkunsTable;
use App\Models\TransferAkun;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TransferAkunResource extends Resource
{
    protected static ?string $model = TransferAkun::class;
    protected static ?string $navigationLabel = 'Transfer Akun';
    protected static ?string $modelLabel = 'Transfer Akun';
    protected static ?string $pluralModelLabel = 'Transfer Akun';
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::ArrowRightStartOnRectangle;
    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return TransferAkunForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransferAkunInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransferAkunsTable::configure($table);
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
            'index' => ListTransferAkuns::route('/'),
            // 'create' => CreateTransferAkun::route('/create'),
            'view' => ViewTransferAkun::route('/{record}'),
            'edit' => EditTransferAkun::route('/{record}/edit'),
        ];
    }
}
