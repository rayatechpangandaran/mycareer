<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'status',
        'author_id',
        'views',
        'published_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

public function likes()
{
    return $this->belongsToMany(
        User::class,
        'article_likes',
        'article_id', 
        'user_id'    
    )->withTimestamps();
}

public function bookmarks()
{
    return $this->belongsToMany(
        User::class,
        'article_bookmarks',
        'article_id',
        'user_id'
    )->withTimestamps();
}

}