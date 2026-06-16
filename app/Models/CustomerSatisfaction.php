<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSatisfaction extends Model
{
    use HasFactory;

    protected $table = 'customer_satisfactions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'city_name',
        'overall_satisfy',
        'employee_behave',
        'resolving_ability',
        'staff_will',
        'employees_explain',
        'rate_quality',
        'like_recommend',
        'meet_needs',
        'suggestions'
    ];
}
