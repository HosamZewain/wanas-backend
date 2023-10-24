<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ActivityLogResource;
use App\Models\ActivityLog;
use App\Repositories\Contracts\ActivityLogContract;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends BaseApiController
{
    /**
     * ActivityLogController constructor.
     * @param ActivityLogContract $repository
     */
    public function __construct(ActivityLogContract $repository)
    {
        parent::__construct($repository, ActivityLogResource::class);
    }

    public function getRelatedFilters(): JsonResponse
    {
        return $this->respondWithJson(ActivityLog::getRelatedFilters());
    }

}
