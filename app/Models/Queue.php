<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'queue_number',
        'client_id',
        'priority',
        'queue_status',
    ];
    
    protected $casts = [
        'priority' => 'boolean',
        'date_issued' => 'datetime',

    ];
    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }
}
