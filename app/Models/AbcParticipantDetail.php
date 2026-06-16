<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbcParticipantDetail extends Model
{
    use HasFactory;

    protected $table = 'abc_participant_details';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'participant_name',
        'participant_address',
        'participant_date_of_birth',
        'BSP_practices'
    ];
}
