<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'content',
        'image',
        'status',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
