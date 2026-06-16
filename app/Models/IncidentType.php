<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentType extends Model
{
    use HasFactory;

    protected $table = 'incident_types';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'absent',
        'behaviour',
        'confidentiality',
        'drug',
        'illness',
        'assault',
        'medication_error',
        'property_damage',
        'self_harm',
        'suicide_attempted',
        'death',
        'other',
        'near_miss'
    ];
}
