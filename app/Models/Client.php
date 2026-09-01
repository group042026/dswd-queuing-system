<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'address',
        'barangay',
        'district',              // ✅ bago
        'municipality',
        'province',
        'region',
        'contact_number',
        'email',
        'occupation',
        'salary',                //'monthly_income'
        'household_size',
        'valid_id_type',
        'valid_id_number',
        'client_category',
        'subcategory',           
        'mode_of_admission',     
        'mode_of_release',       
        'amount',                
        'program_requested',
        'type_of_assistance',    //'reason_for_assistance'
    ];

    public $timestamps = false;

    // public function assessment(): HasMany
    // {
    //     return $this->hasMany(Assessment::class);
    // }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class)->latestOfMany('interview_date');
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