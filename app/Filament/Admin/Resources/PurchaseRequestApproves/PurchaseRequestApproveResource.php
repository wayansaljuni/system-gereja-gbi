<?php

namespace App\Filament\Admin\Resources\PurchaseRequestApproves;

// use App\Filament\Admin\Resources\PurchaseRequestApproves\Pages\CreatePurchaseRequestApprove;
// use App\Filament\Admin\Resources\PurchaseRequestApproves\Pages\EditPurchaseRequestApprove;
use App\Filament\Admin\Resources\PurchaseRequestApproves\Pages\ListPurchaseRequestApproves;
use App\Filament\Admin\Resources\PurchaseRequestApproves\Schemas\PurchaseRequestApproveForm;
use App\Filament\Admin\Resources\PurchaseRequestApproves\Tables\PurchaseRequestApprovesTable;
use App\Models\Hpr;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PurchaseRequestApproveResource extends Resource
{
    protected static ?string $model = Hpr::class;
    protected static string|UnitEnum|null $navigationGroup = 'Purchasing';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Approval PR';
    protected static ?string $modelLabel = 'Approval Purchasing Request';
    protected static ?string $pluralModelLabel = 'Approval Purchasing Requests';

    public static function form(Schema $schema): Schema
    {
        return PurchaseRequestApproveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseRequestApprovesTable::configure($table);
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
            'index' => ListPurchaseRequestApproves::route('/'),
            // 'create' => CreatePurchaseRequestApprove::route('/create'),
            // 'edit' => EditPurchaseRequestApprove::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        // Super Admin bisa melihat semua cabang
        if ($user->hasRole('super_admin') || $user->kd_cab === '00') {
            return $query;
        }

        // User yang tidak punya cabang tidak boleh melihat data
        if (blank($user->kd_cab)) {
            return $query->whereRaw('1 = 0');
        }

        // User biasa hanya melihat cabangnya
        return $query->where('kd_cab', $user->kd_cab);
    }    
}