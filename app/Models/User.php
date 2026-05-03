<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'username', 'role', 'cabang_id', 'permissions'];
    protected $hidden = ['password', 'remember_token'];

    public function cabang()
    {
        return $this->belongsTo(\App\Models\Cabang::class, 'cabang_id');
    }

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
            'permissions' => 'array',
        ];
    }

    /**
     * Check if user has permission to access a feature.
     */
    public function hasPermission($permission): bool
    {
        // If permissions is null (existing users not yet configured), grant access by default
        if ($this->permissions === null) {
            return true;
        }

        return in_array($permission, $this->permissions);
    }
}
