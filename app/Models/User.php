<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'username',
        'license_number',
        'password',
        'status',
        'contact_number',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    public function activity_logs(): HasMany{
        return $this->hasMany(ActivityLog::class);
    }

    public function reports(): HasMany{
        return $this->hasMany(Report::class);
    }

    public function clientProcessing(): HasMany{
        return $this->hasMany(ClientProcessing::class);
    }

    //chinecheck nito if yung user ay may roles
    //gagamitin yan for gates at role-based redirects
    //sa code na ito gumamit ng query builder
    // public function hasRole(string $roleName): bool{
    //     return $this->roles()
    //         ->where('roles.role_name', $roleName) 
    //         ->exists();
    // }

    //standard approach
    public function hasRole(string $roleName): bool{
        return $this->roles->contains('role_name', $roleName);
    }

    public function dashboardRoute(): string
    {
        if ($this->hasRole('admin')) return route('admin.dashboard');
        if ($this->hasRole('receptionist')) return route('receptionist.dashboard');
        if ($this->hasRole('social worker')) return route('social-worker.dashboard');
        if ($this->hasRole('approving officer')) return route('approving-officer.dashboard');

        return route('login');
    }
}
