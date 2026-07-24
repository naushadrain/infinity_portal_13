<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    protected $table = 'customer_feedbacks';

    protected $fillable = [
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
    ];

    protected $casts = [
        'wants_interpreter' => 'boolean',
        'wants_response'    => 'boolean',
    ];
}
