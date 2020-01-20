<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    protected $table = 'tags';

    protected $fillable = ['tag_name', 'slug', 'created_at', 'updated_at'];
}
