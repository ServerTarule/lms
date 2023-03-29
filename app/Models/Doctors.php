<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Doctors
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctors whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Doctors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

}
