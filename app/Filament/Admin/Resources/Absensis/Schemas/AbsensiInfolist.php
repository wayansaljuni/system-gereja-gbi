<?php

namespace App\Filament\Admin\Resources\Absensis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AbsensiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =====================================================
                // INFORMASI IBADAH
                // =====================================================
                Section::make('Informasi Ibadah')
                    ->description('Informasi pelaksanaan ibadah dan waktu absensi.')
                    ->icon('heroicon-o-building-library')
                    ->iconColor('primary')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 3,
                        ])
                            ->schema([

                                TextEntry::make('ibadah.nama')
                                    ->label('Nama Ibadah')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-building-library')
                                    ->iconColor('primary')
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('tanggal')
                                    ->label('Tanggal')
                                    ->date('d F Y')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-calendar-days')
                                    ->iconColor('success')
                                    ->weight('bold'),

                                TextEntry::make('jam')
                                    ->label('Jam Ibadah')
                                    ->time('H:i')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-clock')
                                    ->iconColor('warning')
                                    ->weight('bold'),
                            ]),
                    ])
                    ->compact()
                    ->columnSpanFull(),

                // =====================================================
                // RINGKASAN KEHADIRAN
                // =====================================================
                Section::make('Ringkasan Kehadiran')
                    ->description('Rekapitulasi kehadiran jemaat pada ibadah ini.')
                    ->icon('heroicon-o-chart-bar')
                    ->iconColor('success')
                    ->schema([
                        Grid::make([
                            'default' => 2,
                            'md' => 4,
                        ])
                            ->schema([

                                TextEntry::make('total_jemaat')
                                    ->label('Total Jemaat')
                                    ->state(fn ($record) =>
                                        $record->details()->count()
                                    )
                                    ->badge()
                                    ->color('gray')
                                    ->icon('heroicon-o-users'),

                                TextEntry::make('total_hadir')
                                    ->label('Hadir')
                                    ->state(fn ($record) =>
                                        $record->details()
                                            ->count()
                                    )
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-check-circle'),

                            ]),
                    ])
                    ->compact()
                    ->columnSpanFull(),

                // =====================================================
                // DAFTAR KEHADIRAN
                // =====================================================
                Section::make('Daftar Kehadiran Jemaat')
                    ->description('Daftar jemaat yang tercatat pada absensi ini.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->iconColor('primary')
                    ->schema([

                        TextEntry::make('daftar_kehadiran')
                            ->hiddenLabel()
                            ->state(function ($record): string {
                                $details = $record->details()
                                    ->with('jemaat')
                                    ->get();

                                if ($details->isEmpty()) {
                                    return 'Belum ada data kehadiran.';
                                }

                                $rows = '';

                                foreach ($details as $detail) {
                                    $status = match ($detail->status) {
                                        'hadir' => 'Hadir',
                                        'izin' => 'Izin',
                                        'sakit' => 'Sakit',
                                        'alpha' => 'Alpha',
                                        default => ucfirst($detail->status ?? '-'),
                                    };

                                    $rows .= '
                                        <tr>
                                            <td class="px-3 py-3">' .
                                                e($detail->jemaat?->no_jemaat ?? '-') .
                                            '</td>
                                            <td class="px-3 py-3 font-medium">' .
                                                e($detail->jemaat?->nama ?? '-') .
                                            '</td>
                                            <td class="px-3 py-3">' .
                                                e($detail->keterangan ?? '-') .
                                            '</td>
                                        </tr>
                                    ';
                                }

                                return '
                                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                                        <table class="w-full text-sm text-left">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr>
                                                    <th class="px-3 py-3 font-semibold">No. Jemaat</th>
                                                    <th class="px-3 py-3 font-semibold">Nama Jemaat</th>
                                                    <th class="px-3 py-3 font-semibold">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                ' . $rows . '
                                            </tbody>
                                        </table>
                                    </div>
                                ';
                            })
                            ->html()
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),                // =====================================================
                // CATATAN ABSENSI
                // =====================================================
                Section::make('Catatan Absensi')
                    ->description('Catatan atau keterangan tambahan untuk absensi.')
                    ->icon('heroicon-o-document-text')
                    ->iconColor('info')
                    ->schema([
                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Tidak ada keterangan.')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->iconColor('info')
                            ->columnSpanFull(),
                    ])
                    ->compact()
                    ->collapsible()
                    ->columnSpanFull(),

                // =====================================================
                // INFORMASI SISTEM
                // =====================================================
                Section::make('Informasi Sistem')
                    ->description('Informasi waktu pembuatan dan perubahan data.')
                    ->icon('heroicon-o-information-circle')
                    ->iconColor('gray')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->dateTime('d F Y, H:i')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-plus-circle')
                                    ->iconColor('success'),

                                TextEntry::make('updated_at')
                                    ->label('Terakhir Diperbarui')
                                    ->dateTime('d F Y, H:i')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-arrow-path')
                                    ->iconColor('warning'),
                            ]),
                    ])
                    ->compact()
                    ->collapsible()
                    ->columnSpanFull(),

            ]);
    }
}
