<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\viewleaveModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Leaves newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Leaves newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Leaves query()
 * @mixin \Eloquent
 */
class Leaves extends Model
{

    use HasFactory;

    protected $table = 'leaves';
    protected $fillable = [
        'start_time',
        'end_time',
        'type',
        'comment',
        'employee_id'
    ];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}
