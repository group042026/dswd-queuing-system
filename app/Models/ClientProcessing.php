<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProcessing extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'user_id',
        'queue_id',
        'current_step',
        'current_status',
        'start_time',
        'end_time',
    ];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function queue(): BelongsTo{
        return $this->belongsTo(Queue::class);
    }

}
