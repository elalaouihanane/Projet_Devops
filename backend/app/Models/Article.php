<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'type', 'title',
        'description', 'occasion', 'color', 'image',
        'tags', 'is_published'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean'
    ];

    public function user()      { return $this->belongsTo(User::class); }
    public function category()  { return $this->belongsTo(Category::class); }
    public function likes()     { return $this->hasMany(Like::class); }
    public function comments()  { return $this->hasMany(Comment::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }
}