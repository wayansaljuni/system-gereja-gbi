<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders;

use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages\CreateTransaksiKeuanganHeader;
use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages\EditTransaksiKeuanganHeader;
use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages\ListTransaksiKeuanganHeaders;
use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages\ViewTransaksiKeuanganHeader;
use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Schemas\TransaksiKeuanganHeaderForm;
use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Schemas\TransaksiKeuanganHeaderInfolist;
use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Tables\TransaksiKeuanganHeadersTable;
use App\Models\TransaksiKeuanganHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TransaksiKeuanganHeaderResource extends Resource
{
    protected static ?string $model = TransaksiKeuanganHeader::class;
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedBanknotes;
    protected static ?string $navigationLabel = 'Transaksi Keuangan';
    protected static ?string $modelLabel = 'Transaksi Keuangan';
    protected static ?string $pluralModelLabel = 'Transaksi Keuangan';
    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'TransaksiKeuanganHeader';

    public static function form(Schema $schema): Schema
    {
        return TransaksiKeuanganHeaderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransaksiKeuanganHeaderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksiKeuanganHeadersTable::table($table);
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
            'index' => ListTransaksiKeuanganHeaders::route('/'),
            'create' => CreateTransaksiKeuanganHeader::route('/create'),
            'view' => ViewTransaksiKeuanganHeader::route('/{record}'),
            'edit' => EditTransaksiKeuanganHeader::route('/{record}/edit'),
        ];
    }
}
