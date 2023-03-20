<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'master_id'
    ];

    public function master()
    {
        return $this->belongsTo('App\Models\DynamicMain');
    }
}
