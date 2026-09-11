<?php

namespace App\Filament\Admin\Resources\AgreementTypes\Tables;

// use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Zvizvi\FilamentColumnFilters\Filters\ColumnFilter;

class AgreementTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistColumnSearchesInSession()
            ->columns([
                TextColumn::make('code')
                    ->label('Type Code')
                    ->badge()
                    ->color('primary')
                    ->columnFilter(ColumnFilter::search())
                    // ->searchable(isIndividual:true)
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Agreement Type Name')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columnFilter(ColumnFilter::search())
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('description')
                    ->label('Agreement Type Description')
                    ->limit(40)
                    ->placeholder('—')
                    ->columnFilter(ColumnFilter::search())
                    ->toggleable(),

                IconColumn::make('has_period')
                    ->label('Period')
                    ->boolean()
                    ->columnFilter(ColumnFilter::search())
                    ->trueIcon(Heroicon::OutlinedCalendarDays)
                    ->falseIcon(Heroicon::OutlinedNoSymbol)
                    ->trueColor('info')
                    ->falseColor('gray')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->columnFilter(ColumnFilter::search())
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
