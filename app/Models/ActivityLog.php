<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'user_name', 'event', 'description', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $event, string $description, ?string $ip = null, ?int $userId = null, ?string $userName = null): void
    {
        static::create([
            'user_id'     => $userId  ?? Auth::id(),
            'user_name'   => $userName ?? (Auth::user()?->name ?? 'Guest'),
            'event'       => $event,
            'description' => $description,
            'ip_address'  => $ip,
        ]);
    }
}
