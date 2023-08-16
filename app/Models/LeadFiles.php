<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFiles extends Model
{
    use HasFactory;

    protected $table = 'leadfiles';

    protected $fillable = [
        'lead_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'deleted',
        'called_at'
    ];

    public function lead() : BelongsTo {
        return $this->belongsTo(Lead::class);
    }

}
