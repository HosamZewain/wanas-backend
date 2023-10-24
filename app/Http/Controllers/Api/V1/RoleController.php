<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\RoleContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RoleController extends BaseApiController
{

    /**
     * RoleController constructor.
     * @param RoleContract $repository
     */
    public function __construct(RoleContract $repository)
    {
        parent::__construct($repository, RoleResource::class);
    }

    /**
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        try {
            $role = $this->repository->create($request->validated());
            return $this->respondWithModel($role);
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        try {
            return $this->respondWithModel($role->load('permissions'));
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        try {
            $role = $this->repository->update($role, $request->validated());
            $users_id = $role->users()->pluck('id');
            User::whereIn('id',$users_id)->update(['need_logout'=>1]);
            return $this->respondWithModel($role,200,['role-id'=>$role->id,'role-update'=>true]);
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        try {
            if (!$role->can_be_deleted)
                return $this->respondWithError(__('role can not be deleted'));
            $this->repository->remove($role);
            return $this->respondWithSuccess(__('role deleted successfully'));
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }
}
