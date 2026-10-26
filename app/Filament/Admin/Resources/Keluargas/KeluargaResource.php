<?php

namespace App\Filament\Admin\Resources\Keluargas;

// use App\Filament\Admin\Resources\Keluargas\Pages\CreateKeluarga;
// use App\Filament\Admin\Resources\Keluargas\Pages\EditKeluarga;
use App\Filament\Admin\Resources\Keluargas\Pages\ListKeluargas;
use App\Filament\Admin\Resources\Keluargas\Pages\ViewKeluarga;
use App\Filament\Admin\Resources\Keluargas\Schemas\KeluargaForm;
use App\Filament\Admin\Resources\Keluargas\Schemas\KeluargaInfolist;
use App\Filament\Admin\Resources\Keluargas\Tables\KeluargasTable;
use App\Models\Keluarga;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class KeluargaResource extends Resource
{
    protected static ?string $model = Keluarga::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected static string|UnitEnum|null $navigationGroup = 'Data Jemaat';
    protected static ?string $modelLabel = 'Keluarga';
    protected static ?string $pluralModelLabel = 'Data Keluarga';
    protected static ?string $recordTitleAttribute = 'nama_keluarga';

    public static function form(Schema $schema): Schema
    {
        return KeluargaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KeluargaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KeluargasTable::configure($table);
        // return $table
        //     ->headerActions([
        //         CreateAction::make()
        //             ->label('New Keluarga')
        //             ->icon('heroicon-o-plus')
        //             ->modalHeading('Tambah Keluarga')
        //             ->modalDescription(
        //                 'Masukkan informasi keluarga baru.'
        //             )
        //             ->modalWidth('2xl')
        //             ->createAnother(false),
        //     ])
        //     ->recordActions([
        //         EditAction::make()
        //             ->label('Edit')
        //             ->modalHeading('Edit Data Keluarga')
        //             ->modalWidth('2xl'),
        //     ]);        
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
            'index' => ListKeluargas::route('/'),
            // 'create' => CreateKeluarga::route('/create'),
            'view' => ViewKeluarga::route('/{record}'),
            // 'edit' => EditKeluarga::route('/{record}/edit'),
        ];
    }
}
