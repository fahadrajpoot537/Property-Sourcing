<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image_url',
        'excerpt',
        'content',
        'author_name',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

}
