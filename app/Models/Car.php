<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'car_type',
        'pick_up_location',
        'drop_off_location',
        'pick_up_date',
        'drop_off_date',
        'pick_up_time',
        'drop_off_time',
        'no_of_travelers',
        'no_of_cars',
        'options',
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
        'client_id' => 'integer',
        // 'pick_up_datetime' => 'datetime',
        // 'drop_off_datetime' => 'datetime',
        'options' => 'array',
        'extra_field' => 'array',
        'status' => 'boolean',
        'no_of_travelers' => 'array',
        'car_type' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
