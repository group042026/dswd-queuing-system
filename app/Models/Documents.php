<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documents extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'assessment_id',
        'document_name',
        'file_path',
        'verified',
    ];

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }

    public function assessment(): BelongsTo{
        return $this->belongsTo(Assessment::class);
    }
}
