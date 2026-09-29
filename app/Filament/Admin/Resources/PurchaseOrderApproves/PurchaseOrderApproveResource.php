<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves;

use App\Filament\Admin\Resources\PurchaseOrderApproves\Pages\EditPurchaseOrderApprove;
use App\Filament\Admin\Resources\PurchaseOrderApproves\Pages\ListPurchaseOrderApproves;
use App\Filament\Admin\Resources\PurchaseOrderApproves\Schemas\PurchaseOrderApproveForm;
use App\Filament\Admin\Resources\PurchaseOrderApproves\Schemas\PurchaseOrderApproveInfolist;
use App\Filament\Admin\Resources\PurchaseOrderApproves\Tables\PurchaseOrderApprovesTable;
use App\Models\Hpo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PurchaseOrderApproveResource extends Resource
{
    protected static ?string $model = Hpo::class;
    protected static string|UnitEnum|null $navigationGroup = 'Purchasing';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCheck;
    protected static ?string $navigationLabel = 'Approval PO';
    protected static ?string $modelLabel = 'Approval Purchase Order';
    protected static ?string $pluralModelLabel = 'Approval Purchase Orders';
    protected static ?string $recordTitleAttribute = 'nota';
    protected static ?int $navigationSort = 2;
    public static function form(Schema $schema): Schema
    {
        return PurchaseOrderApproveForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PurchaseOrderApproveInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseOrderApprovesTable::configure($table);
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
            'index' => ListPurchaseOrderApproves::route('/'),
            // 'create' => CreatePurchaseOrderApprove::route('/create'),
            // 'view' => ViewPurchaseOrderApprove::route('/{record}'),
            // 'edit' => EditPurchaseOrderApprove::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        $totalPoNeedApprove = Hpo::perluApprovalPO(auth()->user()?->kd_cab)->count();
        return (string) $totalPoNeedApprove;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Menunggu Approval PO...';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->perluApprovalPO(auth()->user()?->kd_cab)->orderByDesc('hpo.id');        
    }    
}
