<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DynamicValue
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int|null $dependent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DynamicMain|null $dependent
 * @property-read \App\Models\DynamicMain|null $master
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereDependentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
