<?php

namespace App\Support\Spatie;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;


class MediaPathGenerator implements BasePathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->prefixer($media) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->prefixer($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->prefixer($media) . '/responsive/';
    }

    private function prefixer(Media $media): string
    {
        $date = $media->created_at ?? now();
        $prefix = config('media-library.prefix', '');

        $path = $date->format('Y/m');

        return $prefix ? rtrim($prefix, '/') . '/' . $path : $path;
    }
}
