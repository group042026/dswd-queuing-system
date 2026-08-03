<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'control_number',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'sex',
        'birthdate',
        'age',
        'civil_status',
        'barangay',
        'municipality',
        'province',
        'contact_number',
        'email',
        'occupation',
        'monthly_income',
        'household_size',
        'valid_id_type',
        'valid_id_number',
        'client_category',
        'program_requested',
        'reason_for_assistance',
    ];

    public $timestamps = false;

    public function assessment(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Documents::class);
    }

    public function smsNotification(): HasMany
    {
        return $this->hasMany(SMSNotification::class);
    }

    public function queue(): HasMany
    {
        return $this->hasMany(Queue::class);
    }
}