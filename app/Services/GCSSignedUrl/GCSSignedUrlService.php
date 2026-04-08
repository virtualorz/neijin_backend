<?php

namespace App\Services\GCSSignedUrl;

use App\Services\Service;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class GCSSignedUrlService extends Service
{
    public function getUrl(string $path): string
    {
        $cacheKey = 'signed_url:' . md5($path);

        return Cache::remember($cacheKey, 3000, function () use ($path) {
            return Storage::temporaryUrl($path, now()->addMinutes(60));
        });
    }
}
