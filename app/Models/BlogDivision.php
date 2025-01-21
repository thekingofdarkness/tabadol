<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDivision extends Model
{
    use HasFactory;
    protected $fillables = ['title', 'description', 'blog_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
    public function categories()
    {
        return $this->hasMany(BlogCategory::class, 'division_id');
    }
}
