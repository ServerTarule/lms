<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Center
 *
 * @property int $id
 * @property string $centerDetails
 * @property string $mobile
 * @property string $alternateMobile
 * @property string $state
 * @property string $city
 * @property string $ownerName
 * @property string $EmailId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Center newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Center newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Center query()
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereAlternateMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereCenterDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereEmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Center whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Center extends Model
{
    use HasFactory;
    protected $fillable = [
        'centerDetails',
            'mobile',
            'alternateMobile',
            'state',
            'city',
            'ownerName',
            'EmailId',
    ];
}
