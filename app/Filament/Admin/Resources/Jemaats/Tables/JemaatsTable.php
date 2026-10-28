<?php

namespace App\Filament\Admin\Resources\Jemaats\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class JemaatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('no_jemaat')
                    ->label('No. Jemaat')
                    ->icon('heroicon-o-hashtag')
                    ->iconColor('gray')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama Jemaat')
                    ->icon('heroicon-o-user')
                    ->iconColor('primary')
                    ->weight('bold')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state) => match ($state) {
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan',
                            default => '-',
                        }
                    )
                    ->color(
                        fn ($state) => match ($state) {
                            'L' => 'info',
                            'P' => 'warning',
                            default => 'gray',
                        }
                    )
                    ->icon(
                        fn ($state) => match ($state) {
                            'L' => 'heroicon-o-user',
                            'P' => 'heroicon-o-user',
                            default => null,
                        }
                    )
                    ->sortable(),

                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->icon('heroicon-o-cake')
                    ->iconColor('warning')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('keluarga.nama_keluarga')
                    ->label('Keluarga')
                    ->icon('heroicon-o-home')
                    ->iconColor('success')
                    ->placeholder('-')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('organisasi.nama')
                    ->label('Organisasi')
                    ->icon('heroicon-o-building-office-2')
                    ->iconColor('info')
                    ->placeholder('-')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('kelompok.nama')
                    ->label('Kelompok')
                    ->icon('heroicon-o-user-group')
                    ->iconColor('primary')
                    ->placeholder('-')
                    ->searchable(isIndividual: true)
                    ->sortable(),

                TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->icon('heroicon-o-phone')
                    ->iconColor('success')
                    ->placeholder('-')
                    ->searchable(isIndividual: true),

                TextColumn::make('aktif')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state) => $state
                            ? 'Aktif'
                            : 'Tidak Aktif'
                    )
                    ->color(
                        fn ($state) => $state
                            ? 'success'
                            : 'danger'
                    )
                    ->icon(
                        fn ($state) => $state
                            ? 'heroicon-o-check-circle'
                            : 'heroicon-o-x-circle'
                    )
                    ->sortable(),

            ])

            ->filters([
                TernaryFilter::make('aktif')
                    ->label('Status Jemaat')
                    ->placeholder('Semua jemaat')
                    ->trueLabel('Jemaat aktif')
                    ->falseLabel('Jemaat tidak aktif'),
            ])

           ->headerActions([
                CreateAction::make()
                    ->label('New Jemaat')
                    ->icon(Heroicon::OutlinedPlus)
                    ->modalHeading('Tambah Jemaat')
                    ->modalDescription(
                        'Tambahkan Jemaat baru ke dalam master data.'
                    )
                    ->modalWidth('3xl')
                    ->createAnother(false),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedPencil)
                    ->tooltip('Edit')
                    ->modalHeading('Edit')
                    ->modalWidth('3xl'),

                DeleteAction::make()
                    ->label('')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Hapus'),
            ])

            ->defaultSort('nama')
            ->striped()
            ->emptyStateHeading('Belum ada data jemaat')
            ->emptyStateDescription(
                'Silakan tambahkan data jemaat baru.'
            )
            ->emptyStateIcon(
                'heroicon-o-users'
            );
    }
}
