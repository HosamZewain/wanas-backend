<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Repositories\Contracts\PageContract;
use Exception;
use \Illuminate\Http\JsonResponse;

class PageController extends BaseApiController
{
    /**
     * PageController constructor.
     * @param PageContract $repository
     */
    public function __construct(PageContract $repository)
    {
        parent::__construct($repository, PageResource::class, 'Page');
    }
    /**
     * Store a newly created resource in storage.
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function store(PageRequest $request): JsonResponse
    {
        try {
            $page = $this->repository->create($request->validated());
            return $this->respondWithModel($page->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
   /**
    * Display the specified resource.
    * @param Page $page
    * @return JsonResponse
    */
   public function show(Page $page): JsonResponse
   {
       try {
           return $this->respondWithModel($page->load($this->relations));
       }catch (Exception $e) {
           return $this->respondWithError($e->getMessage());
       }
   }
    /**
     * Update the specified resource in storage.
     *
     * @param PageRequest $request
     * @param Page $page
     * @return JsonResponse
     */
    public function update(PageRequest $request, Page $page) : JsonResponse
    {
        try {
            $page = $this->repository->update($page, $request->validated());
            return $this->respondWithModel($page->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param Page $page
     * @return JsonResponse
     */
    public function destroy(Page $page): JsonResponse
    {
        try {
            $this->repository->remove($page);
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * active & inactive the specified resource from storage.
     * @param Page $page
     * @return JsonResponse
     */
    public function changeActivation(Page $page): JsonResponse
    {
        try {
            $this->repository->toggleField($page, 'is_active');
            return $this->respondWithModel($page->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
