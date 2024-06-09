<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'agent_id',
        'title',
        'short_description',
        'person',
        'category',
        'is_featured',
        'previous_price',
        'current_price',
        'valid_from',
        'valid_till',
        'thumbnail',
        'description',
        'location',
        'extra_field',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'agent_id' => 'integer',
        'is_featured' => 'boolean',
        'previous_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'valid_from' => 'date',
        'valid_till' => 'date',
        'extra_field' => 'array',
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
