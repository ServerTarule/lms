<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact',
        'user_id',
        'dob',
        'doj',
        'alternate_contact',
        'designation_id',
        'profile_img',
        'lead_assigned_at'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function designation() : BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    // Relationship With Leads
    public function leads() : HasMany {
        return $this->hasMany(Lead::class, 'lead_id');
    }
}
