<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\templateMaster
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateMaster query()
 * @mixin \Eloquent
 */
class TemplateMaster extends Model
{
    protected $table = 'templateMaster';
    use HasFactory;
}
