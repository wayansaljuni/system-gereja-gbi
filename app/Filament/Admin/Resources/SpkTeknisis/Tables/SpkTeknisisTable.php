<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Zvizvi\FilamentColumnFilters\Filters\ColumnFilter;

class SpkTeknisisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistColumnSearchesInSession()
            ->modifyQueryUsing(function ($query) {
                $user = auth()->user();

                return $query
                    ->with([
                        'produk',
                        'teknisi',
                        'komplain.customer',
                    ])

                    // spk.tgk >= 2026-01-01
                    ->where('tgk', '>=', '2026-01-01')

                    // produk.sts <> Closed
                    ->whereHas('produk', function ($query) {
                        $query->where('sts', '<>', 'Closed');
                    })

                    // teknisi.nik = users.nik
                    ->when(
                        filled($user?->nik),
                        fn ($query) => $query->whereHas(
                            'teknisi',
                            fn ($query) => $query->where('nik', $user->nik)
                        )
                    );
            })

            ->columns([
                TextColumn::make('nospk')
                    ->label('No. SPK / Tgl SPK')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-document-text')
                    ->iconColor('primary')->weight('bold')->color('primary')->searchable()->sortable()
                    ->description(fn ($record): string => $record->tgk)
                    ,
                TextColumn::make('produk.sts')
                    ->label('Status SPK')
                    ->badge()
                    ->icon(fn (?string $state): string => match ($state) {
                        'Closed' => 'heroicon-o-check-circle',
                        'Open' => 'heroicon-o-clock',
                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'Closed' => 'success',
                        'Open' => 'warning',
                        default => 'gray',
                    })
                    ->placeholder('-'),
                    
                TextColumn::make('kdb')
                    ->label('Kode / Serial Produk')
                    ->icon('heroicon-o-qr-code')->columnFilter(ColumnFilter::search())
                    ->iconColor('gray')->searchable()->copyable()
                    ->copyMessage('Serial number copied')
                    ->description(function ($record): HtmlString {
                        $nosr = e($record->produk?->nosr ?? '-');
                        return new HtmlString(
                            '<div class="flex items-center gap-1 text-xs text-gray-500">
                                <span>🏷️</span>
                                <span>' . $nosr . '</span>
                            </div>'
                        );
                    })
                    ,

                TextColumn::make('nmcust')
                    ->label('Customer')
                    ->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-building-office-2')->columnFilter(ColumnFilter::search())
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                    ,

                TextColumn::make('commercial_name')
                    ->label('Comercial Name')
                    ->icon('heroicon-o-building-office')
                    ->iconColor('info')
                    ->getStateUsing(
                        fn ($record) =>
                            $record->komplain?->customer?->nmcomercial ?? '-'
                    )
                    // ->searchable(
                    //     query: function (Builder $query, string $search): Builder {
                    //         return $query->whereHas(
                    //             'komplain.customer',
                    //             fn (Builder $query) =>
                    //                 $query->where('nmcomercial', 'like', "%{$search}%")
                    //         );
                    //     },
                    //     isIndividual: true,
                    // )
                    ,   

                TextColumn::make('nik')
                    ->label('NIK')
                    ->icon('heroicon-o-identification')
                    ->iconColor('gray')
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas('teknisi', function (Builder $query) use ($search) {
                                $query->where('nik', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nama')
                    ->label('Teknisi')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-user-circle')
                    ->iconColor('success')->weight('medium')->searchable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas('teknisi', function (Builder $query) use ($search) {
                                $query->where('nama', 'like', "%{$search}%");
                            });
                        }
                    )
                        ,
                TextColumn::make('produk.nmb')
                    ->label('Nama Produk')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-cube')->iconColor('primary')->weight('medium')->searchable()->wrap()
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                   ,

                TextColumn::make('produk.klh')
                    ->label('Keluhan')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->iconColor('warning')->wrap()->limit(50)
                    ->tooltip(fn ($state) => $state)
                    ->placeholder('-')
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                    ,

                TextColumn::make('produk.krskn')
                    ->label('Kerusakan')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-exclamation-triangle')
                    ->iconColor('danger')->wrap()->limit(50)
                    ->tooltip(fn ($state) => $state)
                    ->placeholder('-')
                    ->toggleable()
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                    ,

                TextColumn::make('produk.solusi')
                    ->label('Solusi')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')->wrap()->limit(50)
                    ->tooltip(fn ($state) => $state)
                    ->placeholder('-')
                    ->toggleable()
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                    ,

                TextColumn::make('produk.tgldtg1')
                    ->label('Kedatangan -1')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->iconColor('success')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('produk.tglplg1')
                    ->label('Kepulangan -1')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->iconColor('danger')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('produk.tgldtg2')
                    ->label('Kedatangan -2')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->iconColor('success')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('produk.tglplg2')
                    ->label('Kepulangan -2')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->iconColor('danger')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('idwo', 'desc')
            ->striped()
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),
            ], position: RecordActionsPosition::BeforeColumns)
            ;
    }
}
