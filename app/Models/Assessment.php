<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'social_worker_id',
        'interview_date',
        'means_verification',
        'assessment_findings',
        'recommendation',
        'assessment_status',
        'remarks',
    ];

    public function socialWorker(): BelongsTo{
        return $this->belongsTo(User::class, 'social_worker_id');
    }

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }
}
