<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'created_at', 'updated_at', 'parent_of'];

    public function parentOf()
    {
        return $this->belongsToMany('App\Models\BackEnd\Category', 'category_parent', 'cat_id', 'cat_pa_id')->withTimestamps();
    }

    public function childOf()
    {
        return $this->belongsToMany('App\Models\BackEnd\Category', 'category_parent', 'cat_pa_id', 'cat_id')->withTimestamps();
    }

    
}
