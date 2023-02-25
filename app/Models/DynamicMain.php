<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicMain extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'master',

    ];

    public function value(){
        return $this->hasMany(DynamicValue::class,'parent_id');
    }

}
