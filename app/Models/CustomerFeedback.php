<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    protected $table = 'customer_feedbacks';

    protected $fillable = [
        'ref_number',
        'city_name',
        'name',
        'email',
        'address',
        'wants_interpreter',
        'interpreter_language',
        'wants_response',
        'preferred_contact_method',
        'feedback_type',
        'respondent_type',
        'respondent_type_other',
        'experience',
        'suggestions',
        'status',
        'date_closed',
        'investigation_undertaken',
        'investigation_record',
        'investigation_findings',
        'investigation_actions',
        'complainant_feedback',
        'improvement_action_required',
        'organisational_improvement_actions',
        'improvement_implemented',
        'manager_note',
    ];

    protected $casts = [
        'wants_interpreter' => 'boolean',
        'wants_response'    => 'boolean',
        'date_closed'       => 'date',
    ];

    protected static function booted(): void
    {
        static::created(function (CustomerFeedback $feedback) {
            $feedback->update(['ref_number' => 'FC-' . str_pad((string) $feedback->id, 6, '0', STR_PAD_LEFT)]);
        });
    }
}
