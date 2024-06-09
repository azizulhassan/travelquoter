<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visa extends Model
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
        'country_of_passport',
        'country_to_visit',
        'passport_type_id',
        'pick_up_date',
        'drop_off_date',
        'no_of_travelers',
        'visit_purpose_id',
        'no_of_visit',
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
        'passport_type_id' => 'integer',
        'pick_up_date' => 'date',
        'drop_off_date' => 'date',
        'visit_purpose_id' => 'integer',
        'options' => 'array',
        'extra_field' => 'array',
        'status' => 'boolean',
        'no_of_travelers' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function passportType(): BelongsTo
    {
        return $this->belongsTo(PassportType::class);
    }

    public function visitPurpose(): BelongsTo
    {
        return $this->belongsTo(VisitPurpose::class);
    }
}
