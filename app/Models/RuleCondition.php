<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuleCondition extends Model
{
    use HasFactory;

    protected $table = 'ruleconditions';

    protected $fillable = [
        'rule_id',
        'master_id',
        'mastervalue_id',
        'condition'
    ];


    public function rule() : BelongsTo {
        return $this->belongsTo(Rule::class);
    }

    public function master() : BelongsTo {
        return $this->belongsTo(DynamicMain::class);
    }

    public function value() : BelongsTo {
        return $this->belongsTo(DynamicValue::class);
    }
}
