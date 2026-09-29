<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Zvizvi\FilamentColumnFilters\Filters\ColumnFilter;

class SpkTeknisisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistColumnSearchesInSession()
            // ->modifyQueryUsing(function ($query) {
            //     $user = auth()->user();

            //     return $query
            //         ->with([
            //             'produk',
            //             'teknisi',
            //             'komplain.customer',
            //         ])

            //         // spk.tgk >= 2026-01-01
            //         ->where('tgk', '>=', '2026-01-01')

            //         // produk.sts <> Closed
            //         ->whereHas('produk', function ($query) {
            //             $query->where('sts', '<>', 'Closed');
            //         })

            //         // teknisi.nik = users.nik
            //         ->when(
            //             filled($user?->nik),
            //             fn ($query) => $query->whereHas(
            //                 'teknisi',
            //                 fn ($query) => $query->where('nik', $user->nik)
            //             )
            //         )
            //         ->when(
            //             filled($user?->kd_cab),
            //             fn ($query) => $query->whereHas(
            //                 'produk',
            //                 fn ($query) => $query->where('kdcab', $user->kd_cab)
            //             )
            //         );
            // })
            ->modifyQueryUsing(function (Builder $query): Builder {
                $user = auth()->user();
                return $query
                    ->select('spk.*')
                    ->join('produk', 'produk.id', '=', 'spk.idp')
                    ->where('spk.tgk', '>=', '2026-01-01')
                    ->where('produk.sts', '<>', 'Closed')
                    ->when(
                        filled($user?->kd_cab),
                        fn (Builder $query) => $query
                            ->where('produk.kdcab', $user->kd_cab)
                    )
                    ->when(
                        filled($user?->nik),
                        fn (Builder $query) => $query->whereExists(
                            function (QueryBuilder $subquery) use ($user): void {
                                $subquery
                                    ->selectRaw('1')
                                    ->from('teknisi')
                                    ->whereColumn('teknisi.nospk', 'spk.nospk')
                                    ->whereColumn('teknisi.noko', 'spk.noko')
                                    ->where('teknisi.nik', $user->nik);
                            }
                        )
                    )
                    ->with([
                        'produk',
                        'teknisi',
                        'komplain.customer',
                    ]);
                })

            ->columns([
                TextColumn::make('nospk')
                    ->label('No. SPK / Date / Status')
                    ->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-document-text')
                    ->iconColor('primary')
                    ->weight('bold')
                    ->color('primary')
                    ->searchable()
                    ->sortable()
                    ->description(function ($record): HtmlString {
                        $tanggal = e($record->tgk ?? '-');
                        $status = $record->produk?->sts ?? '-';

                        $warna = match ($status) {
                            'Closed' => '#15803d',
                            'Process' => '#b45309',
                            default => '#6b7280',
                        };

                        return new HtmlString(
                            '<span style="display:inline-flex; align-items:center; gap:8px;">'
                            . '<span>' . $tanggal . '</span>'
                            . '<span style="color:' . $warna . '; border:1px solid currentColor;'
                            . ' border-radius:6px; padding:1px 6px;">'
                            . e($status)
                            . '</span>'
                            . '</span>'
                        );
                    }),                    

                TextColumn::make('kdb')
                    ->label('SKU / Serial / Product Name')
                    ->icon('heroicon-o-qr-code')
                    ->iconColor('gray')
                    ->copyable()->columnFilter(ColumnFilter::search())
                    ->copyMessage('Kode produk disalin')
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder =>
                            $query->where(function (Builder $query) use ($search) {
                                $query
                                    ->where('spk.kdb', 'like', "%{$search}%")
                                    ->orWhereHas('produk', function (Builder $produk) use ($search) {
                                        $produk
                                            ->where('nosr', 'like', "%{$search}%")
                                            ->orWhere('nmb', 'like', "%{$search}%");
                                    });
                            }),
                        isIndividual: false,
                    )
                    ->formatStateUsing(function ($state, $record): HtmlString {
                        $kdb = e($state ?? '-');
                        $nosr = e($record->produk?->nosr ?? '-');

                        return new HtmlString(
                            '<span style="display:inline-flex; gap:10px; align-items:center;">'
                            . '<span>' . $kdb . '</span>'
                            . '<span style="color:#b45309;">🏷️NoSeri : ' . $nosr . '</span>'
                            . '</span>'
                        );
                    })
                    ->description(function ($record): HtmlString {
                        $namaLengkap = $record->produk?->nmb ?? '-';
                        $namaSingkat = Str::limit($namaLengkap, 40);

                        return new HtmlString(
                            '<span style="color:#f97316;" title="' . e($namaLengkap) . '">'
                            . e($namaSingkat)
                            . '</span>'
                        );
                    }),                                        
                TextColumn::make('nmcust')
                    ->label('Customer')
                    ->columnFilter(ColumnFilter::search())
                    ->limit(50)
                    ->icon('heroicon-o-building-office-2')->columnFilter(ColumnFilter::search())
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                    ,

                TextColumn::make('lok')
                    ->label('Lokasi Product')
                    ->icon('heroicon-o-building-office')
                    ->iconColor('info')
                    ->limit(50)
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                    ->getStateUsing(
                        fn ($record) =>
                            $record->komplain?->lok ?? '-'
                    )
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas(
                                'komplain',
                                fn (Builder $query) =>
                                    $query->where('lok', 'like', "%{$search}%")
                            );
                        },
                        isIndividual: false,
                    )
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

                TextColumn::make('teknisi.nama')
                    ->label('Teknisi')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-user-circle')
                    ->listWithLineBreaks()
                    ->limitList(1)
                    ->expandableLimitedList()
                    ->iconColor('success')->weight('medium')->searchable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereHas('teknisi', function (Builder $query) use ($search) {
                                $query->where('nama', 'like', "%{$search}%");
                            });
                        }
                    )
                        ,
                // TextColumn::make('produk.nmb')
                //     ->label('Nama Produk')->columnFilter(ColumnFilter::search())
                //     ->icon('heroicon-o-cube')->iconColor('primary')->weight('medium')->searchable()->wrap()
                //     ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                //         'style' => 'min-width: 250px; width: 250px;',
                //     ])
                //     ->extraCellAttributes([
                //         'style' => 'min-width: 250px;',
                //     ])
                //    ,

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
            ], )
            // position: RecordActionsPosition::BeforeColumns)
            ;
    }
}
