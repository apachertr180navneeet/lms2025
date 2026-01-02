<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteSubscription extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'institute_subscriptions';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'institute_id',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'teacher_count',
        'student_count',
        'is_active',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    /**
     * Institute relation
     */
    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }

    /**
     * Subscription plan relation
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return now()->gt($this->end_date);
    }
}
