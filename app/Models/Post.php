<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelLike\Traits\Likeable;


class Post extends Model
{
    use HasFactory, SoftDeletes, Likeable;

    protected $fillable = ['blog_id', 'title', 'content', 'photo_url'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the blog that owns the post.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
