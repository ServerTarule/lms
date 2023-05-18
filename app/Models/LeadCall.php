<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadCall extends Model
{
    use HasFactory;

    protected $table = 'leadcalls';

    protected $fillable = [
        'type',
        'lead_id',
        'employee_id',
        'leadstatus_id',
        'remark',
        'called_at',
        'remind_at',
    ];

    public function lead() : BelongsTo {
        return $this->belongsTo(Lead::class);
    }

    public function employee() : BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function leadstatus() : BelongsTo {
        return $this->belongsTo(DynamicValue::class);
    }
}
