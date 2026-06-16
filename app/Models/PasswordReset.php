<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'otp',
        'token',
        'expires_at',
        'is_verified',
        'created_at',
    ];

    protected $casts = [
        'expires_at'  => 'datetime',
        'is_verified' => 'boolean',
        'created_at'  => 'datetime',
    ];

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function canResend(): bool
    {
        return now()->greaterThan($this->created_at->addMinute());
    }

    public function scopeForEmail(\Illuminate\Database\Eloquent\Builder $query, string $email)
    {
        return $query->where('email', $email);
    }
}
