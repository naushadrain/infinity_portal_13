<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceOld extends Model
{
    use HasFactory;

    protected $table = 'resources_';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'added_by',
        'publish',
        'name',
        'file_path',
        'details'
    ];
}
