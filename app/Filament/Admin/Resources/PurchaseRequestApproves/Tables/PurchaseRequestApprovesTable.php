<?php

namespace App\Filament\Admin\Resources\PurchaseRequestApproves\Tables;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Zvizvi\FilamentColumnFilters\Filters\ColumnFilter;

class PurchaseRequestApprovesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistColumnSearchesInSession()
            ->columns([

            TextColumn::make('approval_level_1')
                ->label('Approve-1')
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
                                "Detail Purchase Request - {$record->nota}"
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

                            if (! $user?->hasRole('approvepr')) {
                                return false;
                            }

                            if ($record->approve !== '') {
                                return false;
                            }

                            return $record->kd_cab === $user->kd_cab;
                        })
                    ->action(function ($record) {
                        $user = auth()->user();
                        $bypassLevel2 =
                            in_array($record->jnsbudget , [
                                'DROPPING',
                                'FROM SO',
                                'COMPLAIN CS',
                            ], true)
                            ||
                            (
                                in_array($record->jnsbudget, [
                                    'BUDGET',
                                    'NON BUDGET',
                                ], true)
                                && $record->kd_supp === '1NYTI'
                            )
                            ||
                            (
                                $record->kd_cab !== '00'
                                && $record->gp === 'Y'
                                && $record->jnsbudget === 'BUDGET'
                            );

                        $data = [
                            'approve'   => 'Y',
                            'tglapp'    => now(),
                            'approveby' => $user?->name,
                        ];

                        // Jika memenuhi kondisi bypass,
                        // Level 2 langsung dianggap approved.
                        if ($bypassLevel2) {
                            $data['approve1']   = 'Y';
                            $data['tglapp1']    = now();
                            $data['approveby1'] = 'BYPASS';
                        }

                        $record->update($data);

                        Notification::make()
                            ->title(
                                $bypassLevel2
                                    ? 'PR disetujui Level 1 dan Level 2 di-bypass'
                                    : 'PR disetujui (Level 1)'
                            )
                            ->success()
                            ->send();
                      })
                ),

            TextColumn::make('approval_level_2')
                ->label('Approve-2')
                ->state(function ($record) {
                    // Level 1 belum disetujui
                    if ($record->approve !== 'Y') {
                        return 'Waiting L1';
                    }

                    if ($record->approve1 === 'Y') {
                        return 'Approved';
                    }

                    if ($record->approve1 === 'T') {
                        return 'Rejected';
                    }

                    return 'Setujui';
                })
                ->badge()
                ->color(function ($record) {
                    if ($record->approve !== 'Y') {
                        return 'gray';
                    }

                    return match ($record->approve1) {
                        'Y' => 'success',
                        'T' => 'danger',
                        default => 'warning',
                    };
                })
                ->icon(function ($record) {
                    if ($record->approve !== 'Y') {
                        return 'heroicon-o-clock';
                    }

                    return match ($record->approve1) {
                        'Y' => 'heroicon-o-check-circle',
                        'T' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-check-badge',
                    };
                })
                ->action(
                    Action::make('setujuiL2')
                        ->modalHeading(
                            fn ($record) =>
                                "Detail Purchase Request - {$record->nota}"
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

                            if (! $user?->hasRole('approvepr')) {
                                return false;
                            }

                            if ($record->kd_cab !== $user->kd_cab) {
                                return false;
                            }

                            return $record->approve === 'Y'
                                && $record->approve1 === '';
                        })
                        ->action(function ($record) {
                            $user = auth()->user();

                            /*
                            * Validasi ulang untuk keamanan.
                            */
                            abort_unless(
                                $user?->hasRole('approvepr')
                                && $record->kd_cab === $user->kd_cab
                                && $record->approve === 'Y'
                                && $record->approve1 === '',
                                403
                            );

                            $record->update([
                                'approve1'   => 'Y',
                                'tglapp1'    => now(),
                                'approveby1' => $user->name,
                            ]);

                            Notification::make()
                                ->title('PR disetujui (Level 2)')
                                ->success()
                                ->send();
                        })
                ),            

                TextColumn::make('nota')
                    ->label('No. Nota')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->searchable(isIndividual:true)
                    ->columnFilter(ColumnFilter::search())
                    ->sortable(),

                TextColumn::make('tgl')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->searchable(isIndividual:true)
                    ->icon(Heroicon::OutlinedCalendar)
                    ->sortable(),

                TextColumn::make('nmproject')
                    ->icon(Heroicon::OutlinedCreditCard)
                    ->label('Project Name')
                    ->wrap()
                    ->searchable(isIndividual:true)
                    ->columnFilter(ColumnFilter::search())
                    ->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ]),
                TextColumn::make('nop')
                    ->label('No.SO / Dept')
                    ->searchable(isIndividual:true)
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()
                    ->description(fn ($record): string => $record->dept)
                    ->extraHeaderAttributes([
                        'style' => 'min-width: 100px; width: 100px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 100px;',
                    ]),
                    
                TextColumn::make('kd_cab')
                    ->label('Cabang')
                    ->badge()
                    // ->searchable(isIndividual:true)
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()
                    ->searchable()
                    ->description(fn ($record): string => $record->jnsbudget),

                TextColumn::make('approve')
                    ->label('Status Level-1')
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

                TextColumn::make('approve1')
                    ->label('Status Level-2')
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
                        if ($record->approve !== 'Y') {
                            return 'Menunggu Level-1';
                        }

                        if ($record->approve1 === '') {
                            return 'Belum diproses';
                        }

                        $tgl = optional($record->tglapp1)->format('d M Y') ?? '-';
                        $oleh = $record->approveby1 ?: '-';

                        return "{$tgl} · oleh {$oleh}";
                    }),
            ])
            ->filters([
                Filter::make('perlu_approval')
                    ->label('perlu approve')
                    ->toggle()
                    ->default(true) // aktif otomatis saat halaman pertama dibuka
                    ->query(fn ($query) => $query->where(function ($q) {
                        $q->where('approve', '') // belum diputuskan sama sekali (L1)
                            ->orWhere(function ($q2) {
                                $q2->where('approve', 'Y')->where('approve1', ''); // L1 lolos, nunggu L2
                            });
                    })),
                Filter::make('tanggal')
                    ->schema([
                        DatePicker::make('From')
                            ->label('From Date')
                            ->default(now()->subDays(90)),

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