<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'blocked_until'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function lawyer(): HasOne
    {
        return $this->hasOne(Lawyer::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'member_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function chatbotSessions(): HasMany
    {
        return $this->hasMany(ChatbotSession::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'member_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function moderationActions(): HasMany
    {
        return $this->hasMany(ModerationAction::class, 'admin_id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(LawyerRecommendation::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLawyer(): bool
    {
        return $this->role === 'lawyer';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }
}
