<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $table = 'posts';

    protected $fillable = ['title', 'the_excerpt', 'content', 'slug', 'author_id', 'thumbnail', 'created_at', 'updated_at' , 'type_thumb' , 'video'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\BackEnd\Category', 'post_category', 'post_id', 'cat_id')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\BackEnd\Tag', 'tag_post', 'post_id', 'tag_id')->withTimestamps();
    }

    public function getThumbnail()
    {
        return $this->belongsTo('App\Models\BackEnd\Media', 'thumbnail');
    }
}
