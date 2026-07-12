<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicComplaint extends Model
{
    use HasFactory;

    protected $table = 'public_complaints';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'received_from',
        'email',
        'contact_number',
        'complaint',
        'status',
        'submitted_at',
        'date_closed',
        'investigation_undertaken',
        'investigation_record',
        'investigation_findings',
        'investigation_actions',
        'complainant_feedback',
        'improvement_action_required',
        'organisational_improvement_actions',
        'improvement_implemented',
    ];

    protected $casts = [
        'submitted_at'              => 'date',
        'date_closed'               => 'date',
        'investigation_undertaken'  => 'boolean',
    ];
}
