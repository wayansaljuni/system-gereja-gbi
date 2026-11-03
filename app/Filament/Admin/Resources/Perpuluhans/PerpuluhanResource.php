<?php

namespace App\Filament\Admin\Resources\Perpuluhans;

use App\Filament\Admin\Resources\Perpuluhans\Pages\CreatePerpuluhan;
use App\Filament\Admin\Resources\Perpuluhans\Pages\EditPerpuluhan;
use App\Filament\Admin\Resources\Perpuluhans\Pages\ListPerpuluhans;
use App\Filament\Admin\Resources\Perpuluhans\Pages\ViewPerpuluhan;
use App\Filament\Admin\Resources\Perpuluhans\Schemas\PerpuluhanForm;
use App\Filament\Admin\Resources\Perpuluhans\Schemas\PerpuluhanInfolist;
use App\Filament\Admin\Resources\Perpuluhans\Tables\PerpuluhansTable;
use App\Models\Perpuluhan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PerpuluhanResource extends Resource
{
    protected static ?string $model = Perpuluhan::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::AdjustmentsHorizontal;
    protected static string|UnitEnum|null $navigationGroup =
        'Data Jemaat';
    protected static ?string $modelLabel = 'Perpuluhan';
    protected static ?string $pluralModelLabel = 'Perpuluhan';
    protected static ?string $recordTitleAttribute = 'no_kantong';
    protected static ?int $navigationSort = 5;    


    public static function form(Schema $schema): Schema
    {
        return PerpuluhanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PerpuluhanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerpuluhansTable::configure($table);
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
            'index' => ListPerpuluhans::route('/'),
            'create' => CreatePerpuluhan::route('/create'),
            'view' => ViewPerpuluhan::route('/{record}'),
            'edit' => EditPerpuluhan::route('/{record}/edit'),
        ];
    }
}
