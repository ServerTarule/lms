<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
