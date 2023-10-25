<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\GovernorateRequest;
use App\Http\Resources\GovernorateResource;
use App\Models\Governorate;
use App\Repositories\Contracts\GovernorateContract;
use Exception;
use \Illuminate\Http\JsonResponse;

class GovernorateController extends BaseApiController
{
    /**
     * GovernorateController constructor.
     * @param GovernorateContract $repository
     */
    public function __construct(GovernorateContract $repository)
    {
        parent::__construct($repository, GovernorateResource::class, 'Governorate');
    }
    /**
     * Store a newly created resource in storage.
     * @param GovernorateRequest $request
     * @return JsonResponse
     */
    public function store(GovernorateRequest $request): JsonResponse
    {
        try {
            $governorate = $this->repository->create($request->validated());
            return $this->respondWithModel($governorate->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
   /**
    * Display the specified resource.
    * @param Governorate $governorate
    * @return JsonResponse
    */
   public function show(Governorate $governorate): JsonResponse
   {
       try {
           return $this->respondWithModel($governorate->load($this->relations));
       }catch (Exception $e) {
           return $this->respondWithError($e->getMessage());
       }
   }
    /**
     * Update the specified resource in storage.
     *
     * @param GovernorateRequest $request
     * @param Governorate $governorate
     * @return JsonResponse
     */
    public function update(GovernorateRequest $request, Governorate $governorate) : JsonResponse
    {
        try {
            $governorate = $this->repository->update($governorate, $request->validated());
            return $this->respondWithModel($governorate->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param Governorate $governorate
     * @return JsonResponse
     */
    public function destroy(Governorate $governorate): JsonResponse
    {
        try {
            $this->repository->remove($governorate);
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * active & inactive the specified resource from storage.
     * @param Governorate $governorate
     * @return JsonResponse
     */
    public function changeActivation(Governorate $governorate): JsonResponse
    {
        try {
            $this->repository->toggleField($governorate, 'is_active');
            return $this->respondWithModel($governorate->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
