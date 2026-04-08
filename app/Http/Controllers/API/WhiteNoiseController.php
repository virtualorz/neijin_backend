<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Core\Controllers\WhiteNoise\WhiteNoiseContract;
use App\Models\WhiteNoise;
use App\Services\FileColumnProcess\FileColumnProcessService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Jsadways\LaravelSDK\Core\ReadListParamsDto;
use Jsadways\LaravelSDK\Exceptions\ControllerException;
use Jsadways\LaravelSDK\Exceptions\RepositoryException;
use Jsadways\LaravelSDK\Exceptions\ServiceException;
use Jsadways\LaravelSDK\Http\Requests\Server\ServerRequest;
use ReflectionException;

class WhiteNoiseController extends Controller implements WhiteNoiseContract
{
    public function __construct(
        private readonly FileColumnProcessService $file_column_process_service,
    ){}

    /**
     * @throws ReflectionException
     * @throws RepositoryException
     * @throws ServiceException
     */
    public function create(ServerRequest $request): Model
    {
        $payload = $request->validated();
        $payload = $this->file_column_process_service->create(payload:$payload,model:WhiteNoise::class,upload_dir:'WhiteNoise');
        $request->set_validated($payload);

        return parent::create($request);
    }

    /**
     * @throws Exception
     */
    public function update(ServerRequest $request): Model
    {
        return DB::transaction(function() use($request){
            $filter = json_encode([
                'id_eq'=>$request['id']
            ]);
            $db_data = $this->repository('WhiteNoise')->read_models(new ReadListParamsDto(filter:$filter,per_page:0));
            if(count($db_data) === 0){
                throw new ControllerException('找不到此筆資料');
            }
            $db_data = $db_data->toArray()[0];
            $payload = $request->validated();
            $payload = $this->file_column_process_service->update(payload:$payload,model:WhiteNoise::class,db_data:$db_data,upload_dir:'WhiteNoise');

            $request->set_validated($payload);

            return parent::update($request);
        });
    }
}
