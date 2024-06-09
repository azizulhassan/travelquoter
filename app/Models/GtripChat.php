<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GtripChat extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'gtrip_id',
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
        'client_id' => 'integer',
        'gtrip_id' => 'integer',
        'is_seen' => 'boolean',
        'status' => 'boolean',
    ];

    public function client_id(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function gtrip_id(): BelongsTo
    {
        return $this->belongsTo(Gtrip::class);
    }
}
