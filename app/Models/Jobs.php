<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany};

class Jobs extends Model
{
    public $timestamps = null;

    protected $fillable = [
        'name', 'deadline_at'
    ];

    /**
     * @return belongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, "jobs_users");
    }

    /**
     * @return HasMany
     */
    public function steps(): HasMany
    {
        return $this->hasMany(Steps::class);
    }
}
