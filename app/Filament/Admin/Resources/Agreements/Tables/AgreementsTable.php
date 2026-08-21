<?php

namespace App\Filament\Admin\Resources\Agreements\Tables;

// use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AgreementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('agreement_number')
                    ->label('No. Perjanjian')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Nama Dokumen')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->searchable()
                    ->sortable()
                    ->wrap() 
                    ->weight('medium'),

                TextColumn::make('agreementType.name')
                    ->label('Jenis')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('sifat')
                    ->label('Sifat')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Original' => 'success',
                        'Copy' => 'warning',
                        'Scan' => 'info',
                        default => 'gray',
                    }),

                // TextColumn::make('start_date')
                //     ->label('Mulai')
                //     ->date('d M Y')
                //     ->icon(Heroicon::OutlinedCalendar)
                //     ->sortable()
                //     ->toggleable(),

                // TextColumn::make('end_date')
                //     ->label('Berakhir')
                //     ->date('d M Y')
                //     ->icon(Heroicon::OutlinedCalendar)
                //     ->sortable(),
                TextColumn::make('start_date')
                        ->label('Periode')
                        ->date('d M Y')
                        ->icon(Heroicon::OutlinedCalendar)
                        ->description(fn ($record) => $record->end_date
                            ? 'Berakhir: ' . $record->end_date->format('d M Y')
                            : 'Tidak ada batas akhir')
                        ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'expiring' => 'warning',
                        'expired' => 'danger',
                        'terminated' => 'danger',
                        'cancelled' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                // IconColumn::make('auto_renewal')
                //     ->label('Auto Renew')
                //     ->boolean()
                //     ->trueIcon(Heroicon::OutlinedArrowPath)
                //     ->falseIcon(Heroicon::OutlinedNoSymbol)
                //     ->trueColor('info')
                //     ->falseColor('gray')
                //     ->toggleable(),

                IconColumn::make('reminder_enabled')
                    ->label('Reminder')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedBellAlert)
                    ->falseIcon(Heroicon::OutlinedBellSlash)
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->toggleable(),
                TextColumn::make('notes')
                    ->label('Notes')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->searchable()
                    ->sortable()
                    ->wrap() 
                    ->weight('medium'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Aktif',
                        'expiring' => 'Akan Berakhir',
                        'expired' => 'Berakhir',
                        'terminated' => 'Diakhiri',
                        'cancelled' => 'Dibatalkan',
                    ]),

                SelectFilter::make('agreement_type_id')
                    ->label('Jenis Perjanjian')
                    ->relationship('agreementType', 'name'),

                TernaryFilter::make('auto_renewal')
                    ->label('Perpanjangan Otomatis'),

                TernaryFilter::make('reminder_enabled')
                    ->label('Reminder Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
