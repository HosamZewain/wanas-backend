<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssetModelResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\OpportunityStatusResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\QuestionGroupResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkRegulationResource;
use App\Http\Resources\AwardTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class FilterController extends Controller
{
    public function __invoke($model, Request $request): JsonResponse
    {
        $model = app('App\\Models\\' . $model);
        $request = $request->merge(['scope' => 'micro', 'withoutRelation' => $request['withoutRelation']??true]);
        $only = (array) $request->only;
        $except = (array) $request->except;
        $modelFilters = $model->getFilterModels();

        if (!empty($only)) {
            $modelFilters = array_intersect($modelFilters, $only);
        } elseif (!empty($except)) {
            $modelFilters = array_diff($modelFilters, $except);
        }
        $data = [];
        $filters = $request->all();
        $relations = $request['relations'] ?? [];

        foreach ($modelFilters as $modelFilter) {
            $modelRepo = app('App\\Repositories\\Contracts\\' . $modelFilter . 'Contract');
            $key = Str::plural(lcfirst($modelFilter));
            $modelRelations = isset($relations[$modelFilter]) ? explode(',', $relations[$modelFilter]) : [];
            $data = array_merge($data, [$key =>
                $this->getResource($modelFilter, $modelRepo->searchBySelected(null, [], $filters, $modelRelations))
            ]);
        }
        $customFilters = $model->getFilterCustom();

        if (!empty($only)) {
            $customFilters = array_intersect($customFilters, $only);
        } elseif (!empty($except)) {
            $customFilters = array_diff($customFilters, $except);
        }

        if (empty($request['customFilters'])) {
            foreach ($customFilters as $customFilter) {
                $data = array_merge($data, ["$customFilter" => $model::$customFilter()]);
            }
        } else {
            foreach ($customFilters as $customFilter) {
                if (in_array($customFilter, $request['customFilters'], true)) {
                    $data = array_merge($data, ["$customFilter" => $model::$customFilter()]);
                }
            }
        }

        return response()->json($data);
    }

    public function getResource($model, $data): AnonymousResourceCollection
    {
        return match ($model) {
            'User' => UserResource::collection($data),
            'Role' => RoleResource::collection($data),
            'Company' => CompanyResource::collection($data),
            'Customer' => CustomerResource::collection($data),
            'Project' => ProjectResource::collection($data),
            'Department' => DepartmentResource::collection($data),
            'WorkRegulation' => WorkRegulationResource::collection($data),
            'QuestionGroup' => QuestionGroupResource::collection($data),
            'Employee' => EmployeeResource::collection($data),
            'Position' => PositionResource::collection($data),
            'AssetModel' => AssetModelResource::collection($data),
            'OpportunityStatus' => OpportunityStatusResource::collection($data),
            'AwardType' => AwardTypeResource::collection($data)
        };
    }
}
