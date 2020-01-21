<?php

namespace App\Models\BackEnd;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MediaLibrary extends Model implements HasMedia
{
    use HasMediaTrait;

    public function registerMediaConversions(Media $media = null): void
    {
        if (strstr($media->mime_type, 'image')) {
            $this->addMediaConversion('thumb')
                ->width(600)
                ->height(800)
                ->optimize();
            $this->addMediaConversion('small')
                ->width(50)
                ->height(50)
                ->optimize();
        }
    }
}
