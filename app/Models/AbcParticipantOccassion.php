<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbcParticipantOccassion extends Model
{
    use HasFactory;

    protected $table = 'abc_participant_occassions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'participant_id',
        'observer',
        'reporter',
        'occ_date',
        'occ_time',
        'antecedent',
        'behaviour',
        'consequence',
        'comments'
    ];
}
