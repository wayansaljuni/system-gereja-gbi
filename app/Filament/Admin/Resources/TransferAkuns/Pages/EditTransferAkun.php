<?php

namespace App\Filament\Admin\Resources\TransferAkuns\Pages;

use App\Filament\Admin\Resources\TransferAkuns\TransferAkunResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTransferAkun extends EditRecord
{
    protected static string $resource = TransferAkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
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
}
