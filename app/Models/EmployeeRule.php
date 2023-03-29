<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\EmployeeRule
 *
 * @property int $id
 * @property int $employee_id
 * @property int $rule_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rule> $rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
