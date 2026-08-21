<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Tables;

// use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
// use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AgreementTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(40)
                    ->placeholder('—')
                    ->toggleable(),

                IconColumn::make('has_period')
                    ->label('Periode')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCalendarDays)
                    ->falseIcon(Heroicon::OutlinedNoSymbol)
                    ->trueColor('info')
                    ->falseColor('gray')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->icon(Heroicon::OutlinedClock)
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                TernaryFilter::make('has_period')
                    ->label('Memiliki Periode'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('name');
    }
}
