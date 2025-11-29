<?php

namespace App\Models;

use App\Enums\General\StatusEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    protected $appends = ['full_name', 'name'];

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

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's name (alias for full_name for compatibility).
     */
    public function getNameAttribute(): string
    {
        return $this->getFullNameAttribute();
    }

    /**
     * Active user in users table
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsActive($query): Builder
    {
        return $query->where('users.status', StatusEnum::ACTIVE);
    }

    /**
     * Inactive user in users table
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsInactive($query): Builder
    {
        return $query->where('users.status', StatusEnum::INACTIVE);
    }

    /**
     * Determine if the user has the Super Admin role.
     *
     * @return bool True if user is Super Admin, otherwise false.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === config('constant.SUPER_ADMIN_ROLE_SLUG');
    }

    public function getRoleAttribute()
    {
        return $this->roles->pluck('name')->first();
    }
}
