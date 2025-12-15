<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'content',
        'featured_image'
    ];

    public function images()
    {
        return $this->hasMany(BlogImages::class);
    }
}
