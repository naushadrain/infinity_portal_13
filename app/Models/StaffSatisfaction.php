<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSatisfaction extends Model
{
    use HasFactory;

    protected $table = 'staff_satisfactions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'city_name',
        'enjoy_working',
        'satisfied_career_growth',
        'responsibility_match_strength',
        'work_life_balance',
        'comfortable_feel',
        'feel_stressed',
        'meaningful_work',
        'training_rating',
        'suggestions'
    ];
}
