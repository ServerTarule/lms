<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LeadAssignmentQueue
 *
 * @property int $id
 * @property int $employee_id
 * @property int $lead_id
 * @property string $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rule> $rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue whereRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadAssignmentQueue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadAssignmentQueue extends Model
{
    use HasFactory;

    protected $table = 'lead_assignment_queues';

    protected $fillable = [
        'employee_id',
        'lead_id',
        'is_approved'
    ];

    public function employees() : HasMany {
        return $this->hasMany(Employee::class,'employee_id');
    }

    public function leeds() : HasMany {
        return $this->hasMany(Lead::class,'lead_id');
    }

}
