<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medication';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'pr_name',
        'pr_position',
        'pr_date_occured',
        'pr_time_occured',
        'pr_date_reported',
        'pr_incident_reported_to',
        'cd_name',
        'cd_location',
        'cd_responsible',
        'incident_type',
        'incident_other',
        'incident_background',
        'incident_details',
        'cause_factor',
        'cause_other',
        'immediate_action',
        'action_other',
        'follow_up_action',
        'follow_up_other',
        'action_explaination',
        'action_taken_by',
        'date_completed',
        'signature',
        'manager_note',
    ];
}
