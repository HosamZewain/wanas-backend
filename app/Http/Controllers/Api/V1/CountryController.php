<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Repositories\Contracts\CountryContract;
use Exception;
use \Illuminate\Http\JsonResponse;

class CountryController extends BaseApiController
{
    /**
     * CountryController constructor.
     * @param CountryContract $repository
     */
    public function __construct(CountryContract $repository)
    {
        parent::__construct($repository, CountryResource::class, 'Country');
    }
    /**
     * Store a newly created resource in storage.
     * @param CountryRequest $request
     * @return JsonResponse
     */
    public function store(CountryRequest $request): JsonResponse
    {
        try {
            $country = $this->repository->create($request->validated());
            return $this->respondWithModel($country->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
   /**
    * Display the specified resource.
    * @param Country $country
    * @return JsonResponse
    */
   public function show(Country $country): JsonResponse
   {
       try {
           return $this->respondWithModel($country->load($this->relations));
       }catch (Exception $e) {
           return $this->respondWithError($e->getMessage());
       }
   }
    /**
     * Update the specified resource in storage.
     *
     * @param CountryRequest $request
     * @param Country $country
     * @return JsonResponse
     */
    public function update(CountryRequest $request, Country $country) : JsonResponse
    {
        try {
            $country = $this->repository->update($country, $request->validated());
            return $this->respondWithModel($country->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param Country $country
     * @return JsonResponse
     */
    public function destroy(Country $country): JsonResponse
    {
        try {
            $this->repository->remove($country);
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * active & inactive the specified resource from storage.
     * @param Country $country
     * @return JsonResponse
     */
    public function changeActivation(Country $country): JsonResponse
    {
        try {
            $this->repository->toggleField($country, 'is_active');
            return $this->respondWithModel($country->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
