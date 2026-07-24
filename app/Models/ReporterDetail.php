<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterDetail extends Model
{
    use HasFactory;

    protected $table = 'reporter_details';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'contact',
        'position_title',
        'city',
        'completed',
        'ir_number',
        'manager_note',
    ];

    public function participant()
    {
        return $this->hasOne(ParticipantsDetail::class, 'r_id', 'id');
    }
}
