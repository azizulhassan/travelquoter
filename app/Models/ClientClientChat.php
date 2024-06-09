<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientClientChat extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from',
        'to',
        'attachment',
        'image',
        'message',
        'is_seen',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'from' => 'integer',
        'to' => 'integer',
        'is_seen' => 'boolean',
        'status' => 'boolean',
    ];

    public function from(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
