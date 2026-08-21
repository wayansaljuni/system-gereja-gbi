<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementAttachment extends Model
{
    protected $fillable = [
        'agreement_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
      ];

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }    //
}
