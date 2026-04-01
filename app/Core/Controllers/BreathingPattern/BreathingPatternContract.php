<?php

namespace App\Core\Controllers\BreathingPattern;

use Jsadways\LaravelSDK\Http\Requests\ReadListRequest;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Pagination\LengthAwarePaginator;
use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;

interface BreathingPatternContract
{
    public function create(ServerRequest $request): Model;
    public function read_list(ReadListRequest $request): Collection|LengthAwarePaginator;
    public function update(ServerRequest $request): Model;
}