<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action_type',
        'details',
    ];

    protected $casts = [
        'time_committed' => 'datetime',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
   
    public static function record(string $actionType, string $details)
    {
        return self::create([
            'user_id'     => auth()->id(),
            'action_type' => $actionType,
            'details'     => $details,
        ]);
    }
}   
