<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'lawyer_id',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
