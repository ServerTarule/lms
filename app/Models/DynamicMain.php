<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DynamicMain extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'master' //flag if it is a main master or dynamic master
    ];

    public function values() : HasMany {
        return $this->hasMany(DynamicValue::class,'parent_id');
    }

    public function ruleconditions() : HasMany {
        return $this->hasMany(RuleCondition::class,'master_id');
    }

}
