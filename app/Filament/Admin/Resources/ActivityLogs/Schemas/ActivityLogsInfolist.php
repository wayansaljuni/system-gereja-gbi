<?php

namespace App\Filament\Admin\Resources\ActivityLogs\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityLogsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Log Aktivitas')
                        ->icon('heroicon-o-document-text')
                        ->iconColor('primary')->columnSpanFull()
                        ->columns(7)
                        ->schema([
                            TextEntry::make('causer.name')
                                ->label('Log Name')
                                ->icon('heroicon-o-user')
                                ->iconColor('primary')
                                ->weight('bold')
                                ->color('primary')
                                ->copyable(),

                            TextEntry::make('event')
                                ->label('Event')
                                ->icon('heroicon-o-bolt')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'created' => 'success',
                                    'updated' => 'warning',
                                    'deleted' => 'danger',
                                    default => 'gray',
                                }),
                            TextEntry::make('causer_type')
                                ->label('Causer Type')
                                ->icon('heroicon-o-qr-code')
                                ->copyable()
                                ->placeholder('-'),
                            TextEntry::make('created_at')
                                    ->label('Waktu Aktivitas')
                                    ->icon('heroicon-o-clock')
                                    ->iconColor('info')
                                    ->dateTime('d M Y H:i:s')
                                    ->placeholder('-'),
                            TextEntry::make('attribute_changes')
                                ->label('Attribute Changes')
                                // ->icon('heroicon-o-pencil-square')
                                // ->iconColor('warning')
                                ->state(function ($record) {
                                    $changes = json_decode($record->attribute_changes, true);
                                    if (! is_array($changes)) {
                                        return '-';
                                    }
                                    $old = $changes['old'] ?? [];
                                    $new = $changes['attributes'] ?? [];
                                    $formatValue = function ($value, $field) {
                                        // Khusus field tanggal
                                        if (in_array($field, [
                                            'tgldtg1',
                                            'tglplg1',
                                            'tgldtg2',
                                            'tglplg2',
                                        ])) {
                                            // Anggap tanggal kosong / invalid sebagai "-"
                                            if (
                                                blank($value) ||
                                                str_starts_with((string) $value, '-000001')
                                            ) {
                                                return '-';
                                            }
                                            try {
                                                return Carbon::parse($value)
                                                    ->format('d M Y H:i');
                                            } catch (\Exception $e) {
                                                return $value;
                                            }
                                        }
                                        return blank($value) ? '-' : $value;
                                    };
                                    return collect($new)
                                        ->reject(fn ($value, $field) => in_array($field, [
                                            'updated_at',
                                            'created_at',
                                        ]))
                                        ->map(function ($newValue, $field) use ($old, $formatValue) {
                                            $oldValue = $old[$field] ?? null;
                                            if ($oldValue == $newValue) {
                                                return null;
                                            }
                                            $oldValue = $formatValue($oldValue, $field);
                                            $newValue = $formatValue($newValue, $field);
                                            return "{$field}: {$oldValue} → {$newValue}";
                                        })
                                        ->filter()
                                        ->implode("\n");
                                })
                                ->formatStateUsing(fn ($state) => nl2br(e($state)))
                                ->html()
                                ->columnSpanFull(),
                            ]),
                    ]);
            }
}
