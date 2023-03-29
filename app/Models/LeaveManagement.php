<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeaveManagement
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveManagement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveManagement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveManagement query()
 * @mixin \Eloquent
 */
class LeaveManagement extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'type',
        'description',
    ];
}
