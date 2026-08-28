<?php

namespace App\Filament\Admin\Resources\AgreementReminders;

use App\Filament\Admin\Resources\AgreementReminders\Pages\ListAgreementReminders;
use App\Filament\Admin\Resources\AgreementReminders\Pages\ViewAgreementReminder;
use App\Filament\Admin\Resources\AgreementReminders\Schemas\AgreementReminderForm;
use App\Filament\Admin\Resources\AgreementReminders\Schemas\AgreementReminderInfolist;
use App\Filament\Admin\Resources\AgreementReminders\Tables\AgreementRemindersTable;
use App\Models\AgreementReminder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AgreementReminderResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Agreements';
    protected static ?string $model = AgreementReminder::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BellAlert;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AgreementReminderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AgreementReminderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgreementRemindersTable::configure($table);
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
            'index' => ListAgreementReminders::route('/'),
            // 'create' => CreateAgreementReminder::route('/create'),
            'view' => ViewAgreementReminder::route('/{record}'),
            // 'edit' => EditAgreementReminder::route('/{record}/edit'),
        ];
    }
}
