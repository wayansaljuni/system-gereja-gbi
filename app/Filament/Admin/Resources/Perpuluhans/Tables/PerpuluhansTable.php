<?php

namespace App\Filament\Admin\Resources\Perpuluhans\Tables;

use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PerpuluhansTable
{
    public static function configure(Table $table): Table
    {
return $table
    ->defaultSort('created_at', 'desc')
    ->columns([
        TextColumn::make('no_kantong')
            ->label('No. Kantong')
            ->searchable()
            ->sortable()
            ->weight(FontWeight::Bold)
            ->icon('heroicon-o-identification')
            ->color('primary'),

        TextColumn::make('jemaat.nama')
            ->label('Nama Jemaat')
            ->searchable()
            ->sortable()
            ->description(fn ($record) => 'ID Jemaat: ' . ($record->jemaat?->id ?? '-'))
            ->weight(FontWeight::Medium),

        TextColumn::make('created_at')
            ->label('Tanggal Dibuat')
            ->dateTime('d M Y, H:i')
            ->sortable()
            ->icon('heroicon-o-calendar')
            ->color('gray')
            ->toggleable(isToggledHiddenByDefault: true),

        TextColumn::make('updated_at')
            ->label('Terakhir Diubah')
            ->dateTime('d M Y, H:i')
            ->sortable()
            ->since()
            ->color('gray')
            ->toggleable(isToggledHiddenByDefault: true),
    ])
    ->filters([
        //
    ])
    ->recordActions([
        // ViewAction::make()
        //     ->label('Detail')
        //     ->icon('heroicon-o-eye')
        //     ->color('info'),

        EditAction::make()
            ->label('')
            ->icon('heroicon-o-pencil-square')
            ->color('warning'),
    ])

    ;
    }
}
