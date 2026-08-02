<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SMSNotification extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'contact_number',
        'message',
        'status',
    ];

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }

}
