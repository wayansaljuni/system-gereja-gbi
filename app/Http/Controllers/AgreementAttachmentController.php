<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class AgreementAttachmentController extends Controller
{
    public function view(string $path)
    {
        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($path),
            404
        );

        return $disk->response($path);
    }

    public function download(string $path)
    {
        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists($path),
            404
        );

        return $disk->download($path);
    }
}