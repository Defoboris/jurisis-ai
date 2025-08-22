<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModerationAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'target_type',
        'target_id',
        'action',
        'reason',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}
