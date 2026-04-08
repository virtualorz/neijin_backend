<?php
namespace App\Models;

use App\Services\GCSSignedUrl\GCSSignedUrlService;
use Jsadways\LaravelSDK\Models\BaseModel;

class Model extends BaseModel
{
    protected function _schema(): array
    {
        // TODO: Implement _schema() method.
        return [];
    }

    protected function getSignedUrl(?array $file): ?string
    {
        if (!$file || empty($file['path'])) {
            return null;
        }
        return app(GCSSignedUrlService::class)->getUrl($file['path']);
    }
}
