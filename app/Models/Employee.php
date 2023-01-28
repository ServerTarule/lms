<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact',
        'role_id',
        'user_id',
        'dob',
        'doj',
        'alternate_contact',
        'designation_id',
        'profile_img',
    ];
}
