<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
