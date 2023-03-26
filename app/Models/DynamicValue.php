<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DynamicValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
        'dependent_id'
    ];

    public function master() : BelongsTo {
        return $this->belongsTo(DynamicMain::class);
    }

    public function dependent() : BelongsTo {
        return $this->belongsTo(DynamicMain::class);
    }

    public function ruleconditions() : HasMany {
        return $this->hasMany(RuleCondition::class,'mastervalue_id');
    }

}
