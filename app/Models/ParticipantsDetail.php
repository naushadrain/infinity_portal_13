<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantsDetail extends Model
{
    use HasFactory;

    protected $table = 'participants_details';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'r_id',
        'full_name',
        'address',
        'dob',
        'involved_witness',
        'injured',
        'medical_attention'
    ];
}
