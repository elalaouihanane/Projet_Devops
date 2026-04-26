<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;  // ← Retiré : HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'bio',
        'style_prefere',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Relations
    public function articles()  { return $this->hasMany(Article::class); }
    public function likes()     { return $this->hasMany(Like::class); }
    public function comments()  { return $this->hasMany(Comment::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }
}