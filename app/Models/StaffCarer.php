<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffCarer extends Model
{
    use HasFactory;

    protected $table = 'staff_carers';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'full_name',
        'address',
        'staff_other',
        'involved_witness',
        'injured',
        'medical_attention'
    ];
}
