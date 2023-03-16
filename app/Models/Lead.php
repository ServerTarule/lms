<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'name',
        'email',
        'mobileno',
        'master1',
        'master2',
        'master3',
        'treatmenttype',
        'casetype',
        'socialintegration',
        'location',
        'casestatus',
        'receiveddate'
    ];

    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
