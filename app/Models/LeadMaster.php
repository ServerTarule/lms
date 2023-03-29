<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeadMaster
 *
 * @property int $id
 * @property int $lead_id
 * @property int $master_id
 * @property int|null $mastervalue_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lead $lead
 * @property-read \App\Models\DynamicMain $master
 * @property-read \App\Models\DynamicValue|null $mastervalue
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereMastervalueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadMaster whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadMaster extends Model
{
    use HasFactory;

    protected $table = 'leadmasters';

    protected $fillable = [
        'lead_id',
        'master_id',
        'mastervalue_id'
    ];

    public function lead() : BelongsTo {
        return $this->belongsTo(Lead::class);
    }

    public function master() : BelongsTo {
        return $this->belongsTo(DynamicMain::class);
    }

    public function mastervalue() : BelongsTo {
        return $this->belongsTo(DynamicValue::class);
    }
}
