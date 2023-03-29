<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RuleCondition
 *
 * @property int $id
 * @property int $rule_id
 * @property int $master_id
 * @property int $mastervalue_id
 * @property string|null $condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DynamicMain $master
 * @property-read \App\Models\Rule $rule
 * @property-read \App\Models\DynamicValue|null $value
 * @method static \Database\Factories\RuleConditionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereMastervalueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RuleCondition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
