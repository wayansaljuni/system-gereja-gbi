<?php

namespace App\Filament\Admin\Resources\Jemaats\Pages;

use App\Filament\Admin\Resources\Jemaats\JemaatResource;
use App\Services\JemaatService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateJemaat extends CreateRecord
{
    protected static string $resource = JemaatResource::class;
    
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['no_jemaat'] = Jemaat::generateNoJemaat();
    //     return $data;
    // }
    protected function handleRecordCreation(array $data): Model
    {
        // dd([
        // 'method' => 'handleRecordCreation dijalankan',
        // 'data' => $data,
        // ]);
        return JemaatService::create($data);
    }    
    
    protected function getRedirectUrl(): string
    {
        // Kembali ke tabel daftar jemaat
        return $this->getResource()::getUrl('index');
    }
}
