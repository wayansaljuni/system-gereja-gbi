<?php

namespace App\Filament\Admin\Resources\PurchaseRequestApproves\Tables;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
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
                        'style' => 'min-width: 300px; width: 300px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 300px;',
                    ]),
                TextColumn::make('nop')
                    ->label('No.SO / Dept')
                    ->badge()
                    ->searchable(isIndividual:true)
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()
                    ->description(fn ($record): string => $record->dept),
                TextColumn::make('kd_cab')
                    ->label('Cabang')
                    ->searchable(isIndividual:true)
                    ->sortable(),
                TextColumn::make('jnsbudget')
                    ->label('Jenis PR')
                    ->searchable(isIndividual:true)
                    ->sortable(),
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
                    ->label('Hanya yang perlu approval saja')
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
                    ])
            ->recordActions([
                // --- Level 1 ---
                Action::make('setujuiL1')
                    ->label('Setujui (Level-1)')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()?->hasRole('approvepr')
                        && $record->approve === '')
                    ->modalHeading(fn ($record) => "Detail Purchase Request - {$record->nota}")
                    ->modalContent(fn ($record) => view('filament.admin.modals.purchase-request-detail', ['record' => $record]))
                    ->modalWidth('4xl')
                    ->modalSubmitActionLabel('Setujui')
                    // Tombol Cancel/close sudah otomatis disediakan Filament di modal.
                    ->action(function ($record) {
                        $record->update([
                            'approve' => 'Y',
                            'tglapp' => now(),
                            'approveby' => auth()->user()?->name,
                        ]);

                        Notification::make()
                            ->title('PR disetujui (Level 1)')
                            ->success()
                            ->send();
                    }),

                // Action::make('tolakL1')
                //     ->label('Tolak (Level-1)')
                //     ->icon('heroicon-o-x-mark')
                //     ->color('danger')
                //     ->visible(fn ($record) => auth()->user()?->hasRole('approvepr')
                //         && $record->approve === '')
                //     ->requiresConfirmation()
                //     ->modalHeading('Tolak Purchase Request - Level 1')
                //     ->modalDescription(fn ($record) => "Yakin ingin menolak PR nota {$record->nota} (Level 1)?")
                //     ->action(function ($record) {
                //         $record->update([
                //             'approve' => 'T',
                //             'tglapp' => now(),
                //             'approveby' => auth()->user()?->name,
                //         ]);

                //         Notification::make()
                //             ->title('PR ditolak (Level 1)')
                //             ->warning()
                //             ->send();
                //     }),

                // --- Level 2, hanya muncul setelah Level 1 = Y ---
                Action::make('setujuiL2')
                    ->label('Setujui (Level-2)')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()?->hasRole('approvepr')
                        && $record->approve === 'Y'
                        && $record->approve1 === '')
                    ->modalHeading(fn ($record) => "Detail Purchase Request - {$record->nota}")
                    ->modalContent(fn ($record) => view('filament.admin.modals.purchase-request-detail', ['record' => $record]))
                    ->modalWidth('4xl')
                    ->modalSubmitActionLabel('Setujui')
                    ->action(function ($record) {
                        $record->update([
                            'approve1' => 'Y',
                            'tglapp1' => now(),
                            'approveby1' => auth()->user()?->name,
                        ]);

                        Notification::make()
                            ->title('PR disetujui (Level 2)')
                            ->success()
                            ->send();
                    }),

                // Action::make('tolakL2')
                //     ->label('Tolak (Level-2)')
                //     ->icon('heroicon-o-x-mark')
                //     ->color('danger')
                //     ->visible(fn ($record) => auth()->user()?->hasRole('approvepr')
                //         && $record->approve === 'Y'
                //         && $record->approve1 === '')
                //     ->requiresConfirmation()
                //     ->modalHeading('Tolak Purchase Request - Level 2')
                //     ->modalDescription(fn ($record) => "Yakin ingin menolak PR nota {$record->nota} (Level 2)?")
                //     ->action(function ($record) {
                //         $record->update([
                //             'approve1' => 'T',
                //             'tglapp1' => now(),
                //             'approveby1' => auth()->user()?->name,
                //         ]);

                //         Notification::make()
                //             ->title('PR ditolak (Level 2)')
                //             ->warning()
                //             ->send();
                //     }),
            ], position: RecordActionsPosition::BeforeColumns)
            ->defaultSort('tgl', 'desc');
    }
}