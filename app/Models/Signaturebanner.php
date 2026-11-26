<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signaturebanner extends Model
{
    use HasFactory;

    protected $table = 'signaturebanner';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'added_by',
        'publish',
        'name',
        'state',
        'file_path',
        'details',
        'expiry_date',
        'category'
    ];

    /**
     * Public URL of the banner image, served through Laravel
     * (no storage symlink needed).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        $version = '?v=' . ($this->updated_at?->timestamp ?? '');

        // Fallback if routes are cached/outdated on the server.
        if (! \Illuminate\Support\Facades\Route::has('banner.image')) {
            return asset('storage/' . $this->file_path) . $version;
        }

        return route('banner.image', basename($this->file_path)) . $version;
    }
}
