<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cover',
        'profile_picture',
        'name',
        'contact_number',
        'password',
        'email',
        'token',
        'profession',
        'verification_code',
        'email_verified_at',
        'status',
        'user_id',
        'total_earning',
        'month_earning',
        'quote_completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'profession' => 'array',
        'email_verified_at' => 'timestamp',
        'status' => 'boolean',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offers(): HasMany {
        return $this->hasMany(Offer::class, 'id');
    }

    public function agency(): HasOne {
        return $this->hasOne(Agency::class, 'id');
    }

    public function reviews(): HasMany {
        return $this->hasMany(AgentReview::class, 'agent_id');
    }

    public function quotes(): BelongsToMany {
        return $this->belongsToMany(Quote::class, 'quote_agents');
    }
}
