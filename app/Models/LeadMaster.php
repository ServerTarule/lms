<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadMaster extends Model
{
    use HasFactory;

    protected $table = 'leadmasters';

    protected $fillable = [
        'lead_id',
        'master_id',
        'mastervalue_id'
    ];

    public function lead() : BelongsTo {
        return $this->belongsTo(Lead::class);
    }

    public function master() : BelongsTo {
        return $this->belongsTo(DynamicMain::class);
    }

    public function mastervalue() : BelongsTo {
        return $this->belongsTo(DynamicValue::class);
    }
}
