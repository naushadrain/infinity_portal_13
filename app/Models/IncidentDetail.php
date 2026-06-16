<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentDetail extends Model
{
    use HasFactory;

    protected $table = 'incident_details';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'doi',
        'toi',
        'address',
        'date_told_about_incident',
        'time_told_about_incident',
        'front_sign',
        'front_sign1',
        'sign_box',
        'official_sign',
        'manager_sign_date',
        'incident_background'
    ];
}
