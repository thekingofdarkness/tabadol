<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillables = ['title', 'description'];

    public function divisions()
    {
        return $this->hasMany(BlogDivision::class, 'blog_id');
    }
}
