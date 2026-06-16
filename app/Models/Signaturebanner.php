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
}
