<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
