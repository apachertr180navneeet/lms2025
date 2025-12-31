<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institute extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table name
     */
    protected $table = 'institutes';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'status',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get active subscription of institute
     */
    public function subscription()
    {
        return $this->hasOne(InstituteSubscription::class, 'institute_id');
    }

    /**
     * Check if institute is active
     */
    public function isActive(): bool
    {
        return $this->status === true;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
