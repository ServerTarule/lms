<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActionType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ActionTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
