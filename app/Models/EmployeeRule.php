<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeRule extends Model
{
    use HasFactory;

    protected $table = 'employeerules';

    protected $fillable = [
        'employee_id',
        'rule_id',
        'status'
    ];

    public function employees() : HasMany {
        return $this->hasMany(Employee::class,'employee_id');
    }

    public function rules() : HasMany {
        return $this->hasMany(Rule::class, 'rule_id');
    }
}
