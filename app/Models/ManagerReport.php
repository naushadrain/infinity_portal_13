<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerReport extends Model
{
    use HasFactory;

    protected $table = 'manager_reports';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'report_manager_name',
        'report_manager_position',
        'immediate_action_taken',
        'family_notified',
        'investigation_possible_causes',
        'investigation_record',
        'investigation_finding',
        'outcome_incident',
        'investigation_action_completed',
        'informed_date',
        'participant_feedback',
        'reportable_incident',
        'date_of_issue'
    ];
}
