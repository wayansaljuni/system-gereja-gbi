<?php

namespace App\Filament\Admin\Resources\AgreementTypes;

use App\Filament\Admin\Resources\AgreementTypes\Pages\CreateAgreementType;
use App\Filament\Admin\Resources\AgreementTypes\Pages\EditAgreementType;
use App\Filament\Admin\Resources\AgreementTypes\Pages\ListAgreementTypes;
use App\Filament\Admin\Resources\AgreementTypes\Pages\ViewAgreementType;
use App\Filament\Admin\Resources\AgreementTypes\Schemas\AgreementTypeForm;
use App\Filament\Admin\Resources\AgreementTypes\Schemas\AgreementTypeInfolist;
use App\Filament\Admin\Resources\AgreementTypes\Tables\AgreementTypesTable;
use App\Models\AgreementType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AgreementTypeResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Agreements';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBoxXMark ;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Agreement Type';
    protected static ?string $pluralModelLabel = 'Agreement Types';
    protected static ?int $navigationSort = 1;

    
    protected static ?string $model = AgreementType::class;

    public static function form(Schema $schema): Schema
    {
        return AgreementTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AgreementTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgreementTypesTable::configure($table);
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
            'index' => ListAgreementTypes::route('/'),
            'create' => CreateAgreementType::route('/create'),
            'view' => ViewAgreementType::route('/{record}'),
            'edit' => EditAgreementType::route('/{record}/edit'),
        ];
    }
}
