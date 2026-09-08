<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgreementAttachmentController;

Route::get('/', function () {
    return view('welcome');
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

});