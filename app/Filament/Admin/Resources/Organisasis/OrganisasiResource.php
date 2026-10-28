<?php

namespace App\Filament\Admin\Resources\Organisasis;

use App\Filament\Admin\Resources\Organisasis\Pages\ListOrganisasis;
use App\Filament\Admin\Resources\Organisasis\Schemas\OrganisasiForm;
use App\Filament\Admin\Resources\Organisasis\Tables\OrganisasisTable;
use App\Models\Organisasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class OrganisasiResource extends Resource
{
    protected static ?string $model = Organisasi::class;
    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-building-office-2';
    protected static string|UnitEnum|null $navigationGroup =
        'Data Jemaat';
    protected static ?string $modelLabel = 'Organisasi';
    protected static ?string $pluralModelLabel = 'Organisasi';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?int $navigationSort = 4;    

    public static function form(Schema $schema): Schema
    {
        return OrganisasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganisasisTable::configure($table);
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
            'index' => ListOrganisasis::route('/'),
            // 'create' => CreateOrganisasi::route('/create'),
            // 'edit' => EditOrganisasi::route('/{record}/edit'),
        ];
    }
}
