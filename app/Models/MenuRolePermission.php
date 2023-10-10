<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $menu_id
 * @property int $role_id
 * @property boolean $add_permission
 * @property boolean $edit_permission
 * @property boolean $delete_permission
 * @property boolean $view_permission
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RuleCondition> $ruleconditions
 * @property-read int|null $ruleconditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DynamicValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuRolePermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'menu_id',
        'role_id',
        'add_permission',
        'edit_permission',
        'delete_permission',
        'view_permission' 
    ];

    // public function values() : HasMany {
    //     //return $this->hasMany(DynamicValue::class,'parent_id');
    // }
    // public function ruleconditions() : HasMany {
    //     //return $this->hasMany(RuleCondition::class,'master_id');
    // }
}
