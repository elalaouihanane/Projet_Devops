<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Chemin sous la racine web (ex. /images/x.svg). Indépendant de APP_URL : correct derrière
     * nginx sur un port (8081) ou si APP_URL ne correspond pas à l’URL du navigateur.
     */
    public static function relativePublicUrl(string $path): string
    {
        return '/'.ltrim(str_replace('\\', '/', $path), '/');
    }

    /** SVG local de repli (champ vide ou erreur de chargement côté navigateur). */
    public static function placeholderImageUrl(): string
    {
        return self::relativePublicUrl('images/article-placeholder.svg');
    }

    /**
     * Valeur BDD (chemin disque public, ou URL) → URL externe ou chemin relatif /storage|/images|/uploads.
     * Les URL absolues qui pointent vers nos propres /storage/... sont converties en chemin relatif
     * (évite localhost:80 en base alors que le site est sur :8081).
     */
    public static function resolvedPublicMedia(?string $stored): ?string
    {
        if (! is_string($stored)) {
            return null;
        }

        $img = trim($stored);
        if ($img === '') {
            return null;
        }

        if (Str::startsWith($img, ['http://', 'https://'])) {
            $path = parse_url($img, PHP_URL_PATH);
            if (is_string($path) && $path !== '' && $path !== '/') {
                if (Str::startsWith($path, '/storage/')
                    || Str::startsWith($path, '/images/')
                    || Str::startsWith($path, '/uploads/')) {
                    return self::relativePublicUrl($path);
                }
            }

            return $img;
        }

        $img = ltrim($img, '/');

        if (Str::startsWith($img, 'uploads/')) {
            return self::relativePublicUrl($img);
        }

        if (Str::startsWith($img, 'images/')) {
            return self::relativePublicUrl($img);
        }

        return self::relativePublicUrl('storage/'.$img);
    }

    /** URL pour la vignette article (jamais vide : placeholder si besoin). */
    public function publicImageUrl(): string
    {
        return self::resolvedPublicMedia($this->attributes['image'] ?? null)
            ?? self::placeholderImageUrl();
    }
}