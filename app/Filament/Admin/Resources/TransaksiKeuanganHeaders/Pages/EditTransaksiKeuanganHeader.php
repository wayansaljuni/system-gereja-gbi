<?php

namespace App\Filament\Admin\Resources\TransaksiKeuanganHeaders\Pages;

use App\Filament\Admin\Resources\TransaksiKeuanganHeaders\TransaksiKeuanganHeaderResource;
use App\Filament\Widgets\RekapKeuanganStats;
use App\Models\TransaksiKeuanganHeader;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditTransaksiKeuanganHeader extends EditRecord
{
    protected static string $resource = TransaksiKeuanganHeaderResource::class;

    protected function handleRecordUpdate(Model $record,array $data): Model {
        return DB::transaction(function () use ($record, $data) {
            /** @var TransaksiKeuanganHeader $record */

            /*
             * 1. Update header transaksi.
             */
            $record->update([
                'tanggal' => $data['tanggal'],
                'ibadah_id' => $data['ibadah_id'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ]);
            return $record;
        });
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->getRecord()->approve) {
            Notification::make()
                ->title('Transaksi sudah di-approve')
                ->body('Transaksi yang sudah disetujui tidak dapat diedit lagi.')
                ->warning()
                ->send();

            $this->redirect(
                static::getResource()::getUrl('index')
            );
        }
    }    
    protected function beforeSave(): void
    {
        if ($this->getRecord()->approve) {
            Notification::make()
                ->title('Transaksi sudah di-approve')
                ->body('Transaksi yang sudah disetujui tidak dapat diedit lagi.')
                ->warning()
                ->send();

            $this->redirect(
                static::getResource()::getUrl('index')
            );
        }        
    }    
    protected function getHeaderWidgets(): array
    {
        return [
            RekapKeuanganStats::class,
        ];
    }

    protected function getHeaderWidgetsData(): array
    {
        return [
            'record' => $this->getRecord(),
        ];
    }
}