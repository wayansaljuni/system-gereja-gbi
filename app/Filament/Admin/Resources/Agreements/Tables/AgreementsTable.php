<?php

namespace App\Filament\Admin\Resources\Agreements\Tables;

// use Filament\Actions\BulkActionGroup;
// use Filament\Actions\DeleteBulkAction;
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
            ->persistColumnSearchesInSession()
            ->columns([
                TextColumn::make('agreement_number')
                    ->label('Agreement Number')
                    ->badge()
                    ->color('primary')
                    ->searchable(isIndividual:true)
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Document Name')
                    ->icon(Heroicon::OutlinedBookmark)
                    ->searchable(isIndividual:true)
                    ->sortable()
                    ->wrap() 
                    ->weight('medium'),

                TextColumn::make('agreementType.name')
                    ->label('Agreement Type')
                    ->searchable(isIndividual:true)
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('sifat')
                    ->label('Document Type')
                    ->searchable(isIndividual:true)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Original' => 'success',
                        'Copy' => 'warning',
                        'Scan' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('start_date')
                        ->label('Period')
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
                    ->searchable(isIndividual:true)
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
                        'active' => 'Active',
                        // 'expiring' => 'Akan Berakhir',
                        'expired' => 'Expired',
                        'terminated' => 'Terminated',
                        'cancelled' => 'Cancelled',
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
            // ->toolbarActions([
            //     DeleteBulkAction::make(),
            // ])
            ->defaultSort('created_at', 'desc');
    }
}
