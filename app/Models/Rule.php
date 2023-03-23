<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
      'name'/*,
      'rulecondition_id'*/
    ];

    public function ruleconditions() : HasMany {
        return $this->hasMany(RuleCondition::class,'rule_id');
    }
}
