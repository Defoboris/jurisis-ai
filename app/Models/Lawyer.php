<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lawyer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'speciality',
        'bar_id',
        'frim_name',
        'office_address',
        'slug',
        'hadling',
        'bio',
        'vidio_url',
        'is_published',
        'moderation_state',
        'moderation_notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
