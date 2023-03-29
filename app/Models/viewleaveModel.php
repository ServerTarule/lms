<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\viewleaveModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|viewleaveModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|viewleaveModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|viewleaveModel query()
 * @mixin \Eloquent
 */
class viewleaveModel extends Model
{
    
    protected $table = 'leaveMaster';
    protected $fillable = [
        'employeeName',
        'fromDate',
        'endDate',
        'startTime',
        'endTime',
        'upComingLeaves',
        'leaveType',
        'leaveDescription',
    ];
    use HasFactory;
}
