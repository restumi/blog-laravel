<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogImages extends Model
{
    protected $fillable = [
        'blog_id',
        'img_path'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
