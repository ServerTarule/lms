<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Lead
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobileno
 * @property string|null $altmobileno
 * @property string $receiveddate
 * @property string|null $remark
 * @property int|null $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeadMaster> $leadmasters
 * @property-read int|null $leadmasters_count
 * @method static \Database\Factories\LeadFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereAltmobileno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereMobileno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereReceiveddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobileno',
        'altmobileno',
        'receiveddate',
        'remark',
        'employee_id'
    ];

//Schema::create('leads', function (Blueprint $table) {
//    $table->id();
//    $table->string('name');
//    $table->string('email');
//    $table->string('mobileno');
//    $table->string('altmobileno')->nullable();
//    $table->dateTime('receiveddate');
//    $table->longText('remark')->nullable();
//    $table->timestamps();
//});
    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function leadmasters() : HasMany {
        return $this->hasMany(LeadMaster::class,'lead_id');
    }
}
