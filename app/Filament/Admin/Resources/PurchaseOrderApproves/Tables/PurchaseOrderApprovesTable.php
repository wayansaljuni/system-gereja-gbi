<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Tables;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Zvizvi\FilamentColumnFilters\Filters\ColumnFilter;

class PurchaseOrderApprovesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistColumnSearchesInSession()
            ->columns([
            TextColumn::make('approval_level_1')
                ->color('success')
                ->label('Approval')
                ->weight('bold')
                ->state(function ($record) {
                    if ($record->approve === 'Y') {
                        return 'Approved';
                    }
                    if ($record->approve === 'T') {
                        return 'Rejected';
                    }
                    return 'Setujui';
                })
                ->badge()
                ->color(fn ($record) => match ($record->approve) {
                    'Y' => 'success',
                    'T' => 'danger',
                    default => 'warning',
                })
                ->icon(fn ($record) => match ($record->approve) {
                    'Y' => 'heroicon-o-check-circle',
                    'T' => 'heroicon-o-x-circle',
                    default => 'heroicon-o-check',
                })
                ->action(
                    Action::make('setujuiL1')
                        ->modalHeading(
                            fn ($record) =>
                                "Detail Purchase Orders - {$record->nota}"
                        )
                        ->modalContent(
                            fn ($record) => view(
                                'filament.admin.modals.purchase-request-detail',
                                ['record' => $record]
                            )
                        )
                        ->modalWidth('4xl')
                        ->modalSubmitActionLabel('Setujui')
                        ->visible(function ($record) {
                            $user = auth()->user();
                            if (! $user?->hasRole('approvepo')) {
                                return false;
                            }
                            if ($record->approve !== '') {
                                return false;
                            }
                            return $record->kd_cab === $user->kd_cab;
                        })
                ),

                       
                TextColumn::make('nota')
                    ->label('No. Nota')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()
                    ->badge()
                    ->description(fn ($record): string => $record->inventory),

                TextColumn::make('tgl')
                    ->label('Tanggal')->date('d/m/Y')
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()->searchable()->icon(Heroicon::OutlinedCalendar)
                    ->sortable(),

                TextColumn::make('sbyr')
                    ->icon(Heroicon::OutlinedCreditCard)
                    ->label('Term Of Payment')
                    ->wrap()
                    // ->searchable(isIndividual:true)
                    ->columnFilter(ColumnFilter::search())
                    ->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ]),
                TextColumn::make('no_pr')
                    ->label('No.PR')
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()
                    ->description(fn ($record): string => $record->kons)
                    ->extraHeaderAttributes([
                        'style' => 'min-width: 100px; width: 100px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 100px;',
                    ]),
                    
                TextColumn::make('kd_supp')
                    ->label('Supplier')->columnFilter(ColumnFilter::search())
                    ->sortable()->searchable(),
                TextColumn::make('kd_cab')
                    ->label('Cabang')->badge()->columnFilter(ColumnFilter::search())
                    ->sortable()->searchable(),
                    // ->description(fn ($record): string => $record->jnsbudget),
                TextColumn::make('gp')
                    ->label('General Purchase')->badge()->columnFilter(ColumnFilter::search())
                    ->color('success')
                    ->sortable()->searchable(),
                TextColumn::make('kons')
                    ->label('Konsinyasi')->badge()->columnFilter(ColumnFilter::search())
                    ->sortable()->searchable(),
                TextColumn::make('ippn')
                    ->label('PPN')->badge()->columnFilter(ColumnFilter::search())
                    ->color('warning')
                    ->sortable()->searchable(),

                TextColumn::make('approve')
                    ->label('Status Approved')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'Y' => 'Disetujui',
                        'T' => 'Ditolak',
                        default => 'Menunggu',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'Y' => 'success',
                        'T' => 'danger',
                        default => 'warning',
                    })
                    ->icon(fn (?string $state) => match ($state) {
                        'Y' => 'heroicon-o-check-circle',
                        'T' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-clock',
                    })
                    ->description(function ($record) {
                        if ($record->approve === '') {
                            return 'Belum diproses';
                        }
                        $tgl = optional($record->tglapp)->format('d M Y') ?? '-';
                        $oleh = $record->approveby ?: '-';
                        return "{$tgl} · oleh {$oleh}";
                    }),

            ])
            ->filters([
                Filter::make('tanggal')
                    ->schema([
                        DatePicker::make('From')
                            ->label('From Date')
                            ->default(now()->subDays(180)),

                        DatePicker::make('Until')
                            ->label('Until Date')
                            ->default(today()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['From'] ?? null,
                                fn (Builder $query, $date) =>
                                    $query->whereDate('tgl', '>=', $date)
                            )
                            ->when(
                                $data['Until'] ?? null,
                                fn (Builder $query, $date) =>
                                    $query->whereDate('tgl', '<=', $date)
                            );
                    }),
                ]);
                
     }
}
