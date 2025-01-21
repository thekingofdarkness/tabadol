<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillables = ['title', 'content', 'uid', 'thumbnail'];
    function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }
    public function versions()
    {
        return $this->hasMany(ArticleVersion::class, 'article_id');
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }
}
