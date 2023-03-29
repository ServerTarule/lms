<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DynamicMain
 *
 * @property int $id
 * @property string $name
 * @property int $master
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DynamicValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain query()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicMain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
