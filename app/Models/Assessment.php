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
        'approving_officer_id',
        'approval_status',
        'approval_remarks',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function approvingOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approving_officer_id');
    }

    public function socialWorker(): BelongsTo{
        return $this->belongsTo(User::class, 'social_worker_id');
    }

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }
}
