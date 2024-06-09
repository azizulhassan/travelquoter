<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'mobile_number',
        'email',
        'budget',
        'receive_quote_via_call',
        'receive_quote_via_email',
        'receive_quote_via_sms',
        'suitable_time',
        'comment',
        'status',
        'reason',
        'extra_field',
        'agent_id',
        'user_id',
        'file',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'receive_quote_via_call' => 'boolean',
        'receive_quote_via_email' => 'boolean',
        'receive_quote_via_sms' => 'boolean',
        'suitable_time' => 'array',
        'extra_field' => 'array',
        'agent_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
