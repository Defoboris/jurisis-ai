<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawyerRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lawyer_id',
        'score',
        'reason',
    ];

    protected $casts = [
        'reason' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(Lawyer::class);
    }
}
