<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Communication extends Model
{
    use HasFactory;

    protected $table = 'communications';

    protected $fillable = [
        'type',
        'message',
        'subject',
        'content',
        'schedule',
        'schedule_unit',
        'words',
        'template_id',
        'rule_id'
    ];

    public function template() : BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function rule() : BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }

    public function leads() : BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'communicationleads', 'communication_id', 'lead_id');
    }

}
