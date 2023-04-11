<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunicationLead extends Model
{
    use HasFactory;

    protected $table = 'communicationleads';

    protected $fillable = [
        'communication_id',
        'rule_id',
        'lead_id'
    ];

    public function communications() : HasMany {
        return $this->hasMany(Communication::class, 'communication_id');
    }

    public function rules() : HasMany {
        return $this->hasMany(Rule::class, 'rule_id');
    }

    public function leads() : HasMany {
        return $this->hasMany(Lead::class, 'lead_id');
    }
}
