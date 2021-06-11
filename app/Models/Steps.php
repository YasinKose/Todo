<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steps extends Model
{
    protected $fillable = ['name', 'status', 'user_id'];
}
