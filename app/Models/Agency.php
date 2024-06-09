<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id',
        'agency_name',
        'mobile_number',
        'abn_acn',
        'website_url',
        'do_you_operate_outside_australia',
        'do_you_operate_through_your_website',
        'business_description',
        'country_id',
        'state_id',
        'services',
        'street_address',
        'postcode',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'agent_id' => 'integer',
        'do_you_operate_outside_australia' => 'boolean',
        'do_you_operate_through_your_website' => 'boolean',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'services' => 'array',
        'status' => 'boolean',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
