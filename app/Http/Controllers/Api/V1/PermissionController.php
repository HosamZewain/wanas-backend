<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Repositories\Contracts\PermissionContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class PermissionController extends BaseApiController
{
    /**
     * PermissionController constructor.
     * @param PermissionContract $repository
     */
    public function __construct(PermissionContract $repository)
    {
        parent::__construct($repository, PermissionResource::class);
    }

    public function __invoke(): Collection|JsonResponse|array
    {
        $models = Permission::all()->groupBy('model');
        return $this->respondWithJson($models);
    }
}
