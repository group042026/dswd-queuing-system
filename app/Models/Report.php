<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'created_by',
        'report_type',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
}
