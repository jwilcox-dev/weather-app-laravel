<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_code',
        'description',
        'notifications'
    ];

    protected $hidden = [
        'id',
        'user_id',
        'notifications',
        'created_at',
        'updated_at'
    ];
}