<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteAgent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quote_id',
        'agent_id',
    ];

    protected $casts = [
        'quote_id' => 'integer',
        'agent_id' => 'integer',
    ];

    public function quote(): BelongsTo {
        return $this->belongsTo(Quote::class);
    }

    public function agent(): BelongsTo {
        return $this->belongsTo(Agent::class);
    }
}
