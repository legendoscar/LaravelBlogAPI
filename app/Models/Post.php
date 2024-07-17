<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['blog_id', 'title', 'content', 'photo_url'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
