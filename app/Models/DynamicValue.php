<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function master() : BelongsTo {
        return $this->belongsTo(DynamicMain::class);
    }

}
