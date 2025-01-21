<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillables = ['title', 'description'];
    public function division()
    {
        return $this->belongsTo(BlogDivision::class, 'division_id');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
