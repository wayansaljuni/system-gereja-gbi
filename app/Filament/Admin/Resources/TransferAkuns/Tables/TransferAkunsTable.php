<?php

namespace App\Filament\Admin\Resources\TransferAkuns\Tables;

use App\Models\TransferAkun;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransferAkunsTable
{
    public static function configure(Table $table): Table
    {
    return $table
        ->defaultSort('tanggal', 'desc')
        ->columns([
            TextColumn::make('approve')
                ->label('Status')
                ->badge()
                ->formatStateUsing(
                    fn ($state) => $state ? 'Disetujui' : 'Menunggu'
                )
                ->color(
                    fn ($state) => $state ? 'success' : 'warning'
                )
                ->icon(
                    fn ($state) => $state
                        ? 'heroicon-o-check-circle'
                        : 'heroicon-o-clock'
                )
                ->sortable(),

            TextColumn::make('tanggal')
                ->label('Tanggal Transfer')
                ->dateTime('d M Y, H:i')
                ->icon('heroicon-o-calendar-days')
                ->sortable()
                ->searchable(isIndividual: true),

            TextColumn::make('akunAsal.nama')
                ->label('Akun Asal')
                ->icon('heroicon-o-arrow-up-circle')
                ->color('danger')
                ->weight('medium')
                ->searchable(isIndividual: true)
                ->sortable(),

            TextColumn::make('akunTujuan.nama')
                ->label('Akun Tujuan')
                ->icon('heroicon-o-arrow-down-circle')
                ->color('success')
                ->weight('medium')
                ->searchable(isIndividual: true)
                ->sortable(),

            TextColumn::make('jumlah')
                ->label('Jumlah Transfer')
                ->money('IDR', locale: 'id')
                ->weight('bold')
                ->color('primary')
                ->sortable()
                ->alignEnd(),

            TextColumn::make('no_referensi')
                ->label('Referensi')
                ->icon('heroicon-o-hashtag')
                ->searchable(isIndividual: true)
                ->placeholder('-')
                ->toggleable(),

             TextColumn::make('ibadah.id')
                ->label('Ibadah')
                ->formatStateUsing(
                    fn ($state) => $state ? 'Ibadah #' . $state : '-'
                )
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('keterangan')
                ->label('Keterangan')
                ->limit(40)
                ->placeholder('-')
                ->wrap()
                ->toggleable(),

            TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime('d/m/Y H:i')
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->recordActions([
            Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Setujui Transfer Akun')
                ->modalDescription(
                    'Apakah Anda yakin ingin menyetujui transfer ini?'
                )
                ->modalSubmitActionLabel('Ya, Setujui')
                ->visible(fn (TransferAkun $record): bool => ! $record->approve)
                ->action(function (TransferAkun $record): void {
                    $record->update([
                        'approve' => true,
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Transfer Disetujui')
                        ->body('Transfer akun berhasil disetujui.')
                        ->send();
                }),

            EditAction::make()
                ->label('')
                ->visible(fn (TransferAkun $record): bool => ! $record->approve)
                ->icon('heroicon-o-pencil-square')
                ->tooltip('Edit Transfer Akun'),

            DeleteAction::make()
                ->label('')
                ->icon('heroicon-o-trash')
                ->tooltip('Hapus Transfer Akun')
                ->color('danger')
                ->visible(fn (TransferAkun $record): bool => ! $record->approve),
            ViewAction::make()
                ->label('')
                ->icon('heroicon-o-eye')
                ->tooltip('Lihat Detail Transfer Akun')
                ->color('info'),
        ]);
    }
}
