<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempts extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'email',
        'ip',
        'success',
        'created_at'
    ];

    protected $casts = [
        'success' => 'boolean',
        'created_at' => 'datetime'
    ];
}
