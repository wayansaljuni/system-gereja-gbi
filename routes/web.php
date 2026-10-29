<?php

use App\Http\Controllers\AgreementAttachmentController;
use App\Http\Controllers\TransaksiKeuanganHeaderPrintController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $loginUrl = Route::has('filament.admin.auth.login')
        ? route('filament.admin.auth.login')
        : url('/admin/login');

    return view('welcome', [
        'loginUrl' => $loginUrl,
    ]);
});

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/agreement-attachments/view/{path}',
        [AgreementAttachmentController::class, 'view']
    )
        ->where('path', '.*')
        ->name('agreement-attachments.view');

    Route::get(
        '/agreement-attachments/download/{path}',
        [AgreementAttachmentController::class, 'download']
    )
        ->where('path', '.*')
        ->name('agreement-attachments.download');
        
    Route::get(
        '/transaksi-keuangan-header/{transaksiKeuanganHeader}/print',
        [TransaksiKeuanganHeaderPrintController::class, 'print']
    )->name('transaksi-keuangan-header.print');        

});