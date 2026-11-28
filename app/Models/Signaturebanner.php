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

        // New location: public/signaturebanner/banner.jpg -> /signaturebanner/banner.jpg
        if (str_starts_with($this->file_path, 'signaturebanner/')) {
            return asset($this->file_path);
        }

        // Older uploads still in storage/app/public/banners/...
        return asset('storage/' . $this->file_path);
    }
}
