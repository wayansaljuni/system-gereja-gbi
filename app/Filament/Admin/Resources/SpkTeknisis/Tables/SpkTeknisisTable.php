<?php

namespace App\Filament\Admin\Resources\SpkTeknisis\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
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
                        'spk',
                        'spk.produk',
                        'komplain.customer',
                    ])
                    // Filter NIK hanya jika users.nik terisi
                    ->when(
                        filled($user?->nik),
                        fn ($query) => $query->where('nik', $user->nik)
                    )
                    // Filter SPK mulai 2026-01-01
                    ->whereHas('spk', function ($query) {
                        $query->where('tgk', '>=', '2026-01-01');
                    })                    
                    ->whereHas('spk.produk', function ($query) {
                        $query->where(function ($query) {
                            $query
                                ->where('sts', '<>', 'Closed')
                                ;
                        });
                    });
            })

            ->columns([
                TextColumn::make('spk.nospk')
                    ->label('No. SPK / Tgl SPK')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-document-text')
                    ->iconColor('primary')->weight('bold')->color('primary')->searchable()->sortable()
                    ->description(fn ($record): string => $record->spk->tgk)
                    ,
                TextColumn::make('spk.produk.sts')
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
                    
                TextColumn::make('spk.nosr')
                    ->label('Serial Number')
                    ->icon('heroicon-o-qr-code')->columnFilter(ColumnFilter::search())
                    ->iconColor('gray')->searchable()->copyable()
                    ->copyMessage('Serial number copied')
                    ->description(function ($record): HtmlString {
                        $kdb = e($record->spk?->produk?->kdb ?? '-');
                        return new HtmlString(
                            '<div class="flex items-center gap-1 text-xs text-gray-500">
                                <span>🏷️</span>
                                <span>' . $kdb . '</span>
                            </div>'
                        );
                    })
                    ,

                TextColumn::make('spk.nmcust')
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
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nama')
                    ->label('Teknisi')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-user-circle')
                    ->iconColor('success')->weight('medium')->searchable()
                    ,

                // TextColumn::make('spk.produk.kdb')
                //     ->label('Kode Barang')
                //     ->icon('heroicon-o-tag')
                //     ->iconColor('gray')
                //     ->searchable(),

                TextColumn::make('spk.produk.nmb')
                    ->label('Nama Produk')->columnFilter(ColumnFilter::search())
                    ->icon('heroicon-o-cube')->iconColor('primary')->weight('medium')->searchable()->wrap()
                    ->iconColor('warning')->weight('medium')->searchable()->wrap()->extraHeaderAttributes([
                        'style' => 'min-width: 250px; width: 250px;',
                    ])
                    ->extraCellAttributes([
                        'style' => 'min-width: 250px;',
                    ])
                   ,

                TextColumn::make('spk.produk.klh')
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

                TextColumn::make('spk.produk.krskn')
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

                TextColumn::make('spk.produk.solusi')
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

                TextColumn::make('spk.produk.tgldtg1')
                    ->label('Kedatangan -1')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->iconColor('success')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('spk.produk.tglplg1')
                    ->label('Kepulangan -1')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->iconColor('danger')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('spk.produk.tgldtg2')
                    ->label('Kedatangan -2')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->iconColor('success')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('spk.produk.tglplg2')
                    ->label('Kepulangan -2')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->iconColor('danger')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
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
