<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table name
     */
    protected $table = 'subscription_plans';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'price',
        'user_limit',
        'storage_limit',
        'duration_days',
        'status',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'price'          => 'decimal:2',
        'status'         => 'boolean',
        'user_limit'     => 'integer',
        'storage_limit'  => 'integer',
        'duration_days'  => 'integer',
    ];

    /**
     * Get all institute subscriptions for this plan
     */
    public function instituteSubscriptions()
    {
        return $this->hasMany(InstituteSubscription::class, 'subscription_plan_id');
    }

    /**
     * Scope: only active plans
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
