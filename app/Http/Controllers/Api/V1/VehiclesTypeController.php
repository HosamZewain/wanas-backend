<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\VehiclesTypeRequest;
use App\Http\Resources\VehiclesTypeResource;
use App\Models\VehiclesType;
use App\Repositories\Contracts\VehiclesTypeContract;
use Exception;
use \Illuminate\Http\JsonResponse;

class VehiclesTypeController extends BaseApiController
{
    /**
     * VehiclesTypeController constructor.
     * @param VehiclesTypeContract $repository
     */
    public function __construct(VehiclesTypeContract $repository)
    {
        parent::__construct($repository, VehiclesTypeResource::class, 'VehiclesType');
    }
    /**
     * Store a newly created resource in storage.
     * @param VehiclesTypeRequest $request
     * @return JsonResponse
     */
    public function store(VehiclesTypeRequest $request): JsonResponse
    {
        try {
            $vehiclesType = $this->repository->create($request->validated());
            return $this->respondWithModel($vehiclesType->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
   /**
    * Display the specified resource.
    * @param VehiclesType $vehiclesType
    * @return JsonResponse
    */
   public function show(VehiclesType $vehiclesType): JsonResponse
   {
       try {
           return $this->respondWithModel($vehiclesType->load($this->relations));
       }catch (Exception $e) {
           return $this->respondWithError($e->getMessage());
       }
   }
    /**
     * Update the specified resource in storage.
     *
     * @param VehiclesTypeRequest $request
     * @param VehiclesType $vehiclesType
     * @return JsonResponse
     */
    public function update(VehiclesTypeRequest $request, VehiclesType $vehiclesType) : JsonResponse
    {
        try {
            $vehiclesType = $this->repository->update($vehiclesType, $request->validated());
            return $this->respondWithModel($vehiclesType->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param VehiclesType $vehiclesType
     * @return JsonResponse
     */
    public function destroy(VehiclesType $vehiclesType): JsonResponse
    {
        try {
            $this->repository->remove($vehiclesType);
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * active & inactive the specified resource from storage.
     * @param VehiclesType $vehiclesType
     * @return JsonResponse
     */
    public function changeActivation(VehiclesType $vehiclesType): JsonResponse
    {
        try {
            $this->repository->toggleField($vehiclesType, 'is_active');
            return $this->respondWithModel($vehiclesType->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
