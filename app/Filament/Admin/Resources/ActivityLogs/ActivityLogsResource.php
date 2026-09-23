<?php

namespace App\Filament\Admin\Resources\ActivityLogs;

use App\Filament\Admin\Resources\ActivityLogs\Pages\CreateActivityLogs;
use App\Filament\Admin\Resources\ActivityLogs\Pages\EditActivityLogs;
use App\Filament\Admin\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Admin\Resources\ActivityLogs\Pages\ViewActivityLogs;
use App\Filament\Admin\Resources\ActivityLogs\Schemas\ActivityLogsForm;
use App\Filament\Admin\Resources\ActivityLogs\Schemas\ActivityLogsInfolist;
use App\Filament\Admin\Resources\ActivityLogs\Tables\ActivityLogsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

class ActivityLogsResource extends Resource
{
  protected static ?string $model = Activity::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;
    protected static ?string $navigationLabel = 'Activity Log';
    protected static ?string $modelLabel = 'Activity Log';
    protected static ?string $pluralModelLabel = 'Activity Log';
    protected static string|UnitEnum|null $navigationGroup = 'Setting';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ActivityLogsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivityLogsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityLogsTable::configure($table);
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
            'index' => ListActivityLogs::route('/'),
            // 'create' => CreateActivityLogs::route('/create'),
           'view' => ViewActivityLogs::route('/{record}'),
            // 'edit' => EditActivityLogs::route('/{record}/edit'),
        ];
    }
}
