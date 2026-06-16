<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentForm extends Model
{
    use HasFactory;

    protected $table = 'incident_forms';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'added_by',
        'email_sent',
        'name',
        'category',
        'department_work_incident',
        'date_incident',
        'time_incident',
        'address_location_incident',
        'oncall_accommodation',
        'detail_incident',
        'name_staff_witness',
        'immediate_action_taken',
        'report_incident_date_name',
        'police_notified',
        'client_name',
        'client_dob',
        'name_dob_client',
        'involve_client_behaviour',
        'prn_administered',
        'was_injuries_sustained',
        'was_treatment_required',
        'was_property_damaged',
        'was_incident_reported',
        'ip_address'
    ];
}
