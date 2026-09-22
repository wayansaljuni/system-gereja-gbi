<?php

namespace App\Filament\Admin\Resources\SpkTeknisis;

use App\Filament\Admin\Resources\SpkTeknisis\Pages\EditSpkTeknisi;
use App\Filament\Admin\Resources\SpkTeknisis\Pages\ListSpkTeknisis;
use App\Filament\Admin\Resources\SpkTeknisis\Pages\ViewSpkTeknisi;
use App\Filament\Admin\Resources\SpkTeknisis\Schemas\SpkTeknisiForm;
use App\Filament\Admin\Resources\SpkTeknisis\Schemas\SpkTeknisiInfolist;
use App\Filament\Admin\Resources\SpkTeknisis\Tables\SpkTeknisisTable;
use App\Models\Teknisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SpkTeknisiResource extends Resource
{
    protected static ?string $model = Teknisi::class;
    protected static string|UnitEnum|null $navigationGroup ='CRM';
    protected static string|BackedEnum|null $navigationIcon =Heroicon::OutlinedWrenchScrewdriver;
    protected static ?string $navigationLabel = 'SPK Teknisi';
    protected static ?string $modelLabel = 'SPK Teknisi';
    protected static ?string $pluralModelLabel = 'SPK Teknisi';

    public static function form(Schema $schema): Schema
    {
        return SpkTeknisiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SpkTeknisiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpkTeknisisTable::configure($table);
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
            'index' => ListSpkTeknisis::route('/'),
            // 'create' => CreateSpkTeknisi::route('/create'),
            'view' => ViewSpkTeknisi::route('/{record}'),
            'edit' => EditSpkTeknisi::route('/{record}/edit'),
        ];
    }
}
