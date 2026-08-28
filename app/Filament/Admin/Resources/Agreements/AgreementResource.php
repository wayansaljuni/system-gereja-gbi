<?php

namespace App\Filament\Admin\Resources\Agreements;

use App\Filament\Admin\Resources\Agreements\Pages\CreateAgreement;
use App\Filament\Admin\Resources\Agreements\Pages\EditAgreement;
use App\Filament\Admin\Resources\Agreements\Pages\ListAgreements;
use App\Filament\Admin\Resources\Agreements\RelationManagers\AttachmentsRelationManager;
use App\Filament\Admin\Resources\Agreements\RelationManagers\PartiesRelationManager;
use App\Filament\Admin\Resources\Agreements\RelationManagers\RemindersRelationManager;
use App\Filament\Admin\Resources\Agreements\Schemas\AgreementForm;
use App\Filament\Admin\Resources\Agreements\Tables\AgreementsTable;
use App\Models\Agreement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AgreementResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Agreements';
    protected static ?string $model = Agreement::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;
    protected static ?string $navigationLabel = 'Agreements';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return AgreementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgreementsTable::configure($table);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['agreement_number', 'title', 'pic'];
    }

    public static function getRelations(): array
    {
        return [
            PartiesRelationManager::class,
            AttachmentsRelationManager::class,
            RemindersRelationManager::class,                        //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAgreements::route('/'),
            'create' => CreateAgreement::route('/create'),
            'edit' => EditAgreement::route('/{record}/edit'),
        ];
    }
}
