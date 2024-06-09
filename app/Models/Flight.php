<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
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
        'flight_type',
        'from',
        'to',
        'departure_date',
        'returning_date',
        'trip_days',
        'no_of_passenger',
        'flight_class_id',
        'is_flexible_date',
        'flexible_date',
        'is_visa',
        'airline_id',
        'is_insurance',
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
        'departure_date' => 'date',
        'returning_date' => 'date',
        'flight_class_id' => 'integer',
        'is_flexible_date' => 'boolean',
        'is_visa' => 'boolean',
        'airline_id' => 'integer',
        'is_insurance' => 'boolean',
        'options' => 'array',
        'extra_field' => 'array',
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function flightClass(): BelongsTo
    {
        return $this->belongsTo(FlightClass::class);
    }

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }
}
