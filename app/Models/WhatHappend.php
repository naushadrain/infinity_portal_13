<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatHappend extends Model
{
    use HasFactory;

    protected $table = 'what_happends';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'desciption_of_incident',
        'actoin_taken_by_staff',
        'property_damage',
        'police_contacted',
        'details_of_damage',
        'reported_to_line_manager',
        'manager_name',
        'date',
        'reporter_signature'
    ];
}
