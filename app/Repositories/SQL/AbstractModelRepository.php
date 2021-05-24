<?php

namespace App\Repositories\SQL;

use App\Exceptions\CantDeleteModelException;
use App\Repositories\Contracts\IModelRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use ReflectionException;

abstract class AbstractModelRepository implements IModelRepository
{

    public const RESPONSE_STATUS_OK = 200;
    public const RESPONSE_STATUS_ERROR = 400;
    public const VALIDATION_ERROR = 422;

    public const CODE_STATUS_SUCCESS = 1;
    public const CODE_STATUS_ERROR = 0;
    protected $defaultFilters = [];

    /**
     * @var Model
     */
    protected $model;

    /**
     * AbstractModelRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateAll($attributes = [])
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            // $filtered = $this->cleanUpAttributes($attributes);
            return $this->model->query()->update($attributes);
        }
        return false;
    }

    protected function cleanUpAttributes($attributes)
    {
        return $attributes->filter(function ($key) {
            return $this->model->isFillable($key);
        })->toArray();
    }

    /**
     * @param array $attributes
     * @param null $id
     * @return mixed
     */
    public function createOrUpdate($attributes = [], $id = null)
    {
        if (empty($attributes)) {
            return false;
        }

        // Clean the attributes from unnecessary inputs
        //  $filtered = $this->cleanUpAttributes($attributes);

        if ($id) {
            $model = $this->model->find($id);
            return $this->update($model, $attributes);
        }

        return $this->create($attributes);
    }

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Model $model, $attributes = [])
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            //  $filtered = $this->cleanUpAttributes($attributes);

            return tap($model)->update($attributes)->fresh();
        }

        return false;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = [])
    {
        if (!empty($attributes)) {
            // Clean the attributes from unnecessary inputs
            //  $filtered = $this->cleanUpAttributes($attributes);

            return $this->model->create($attributes);
        }

        return false;
    }

    /**
     * @param array $searchIn
     * @param array $attributes
     * @return mixed
     */
    public function UpdateOrCreate(array $searchIn = [], array $attributes = [])
    {
        return $this->model->updateOrCreate($searchIn, $attributes);
    }

    /**
     * @param Model $model
     *
     * @return mixed
     * @throws Exception
     */
    public function remove(Model $model)
    {
        // Check if has relations
        foreach ($model->getDefinedRelations(true) as $relation) {
            if ($model->$relation()->exists()) {
                throw new CantDeleteModelException("Can't delete, model has related records");
            }
        }

        return $model->delete();
    }

    public function count()
    {
        $query = $this->model;

        return $query->count();
    }

    /**
     * @param int $id
     * @param array $relations
     *
     * @return mixed
     */
    public function find(int $id, array $relations = [])
    {
        $query = $this->model;
        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function findBy($key, $value)
    {
        return $this->model->where($key, $value)/*->dump()*/ ->first();
    }

    /**
     * @param mixed $fields
     *
     * @return mixed
     */
    public function findByFields(array $fields)
    {
        $query = $this->model;

        if (isset($fields['and'])) {
            $query = $query->where($fields['and']);
        }

        if (isset($fields['or'])) {
            $query = $query->orWhere(function (Builder $query) use ($fields) {
                foreach ($fields['or'] as $condition) {
                    $query = $query->orWhere($condition[0], $condition[1]);
                }
            });
        }

        if (!isset($fields['and']) && isset($fields['or'])) {
            $query = $query->where($fields);
        }

        return $query->first();
    }


    /**
     * @param $status
     * @param $msg
     * @param $data
     * @return JsonResponse
     */
    public function ResponseJson($status, $msg, $data)
    {
        $response = [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];

        return Response::json($response, 200);
    }

    /**
     * @param $status
     * @param $msg
     * @param $data
     * @return JsonResponse
     */
    public function ResponseJsonSuccess($status, $msg, $data)
    {
        $response = [
            'status' => self::RESPONSE_STATUS_OK,
            'code_status' => $status ?? 1,
            'msg' => $msg,
            'data' => $data
        ];

        return Response::json($response, 200);
    }

    /**
     * @param $status
     * @param $msg
     * @param $data
     * @param array $errors
     * @return JsonResponse
     */
    public function ResponseJsonError($status, $msg, $data = null, $errors = null)
    {
        $response = [
            'status' => self::RESPONSE_STATUS_ERROR,
            'code_status' => $status ?? 0,
            'msg' => $msg,
            'data' => $data,
            'errors' => $errors,
        ];
        return response()->json($response);
    }

    /**
     * @param array $values
     * @param array|null $attributes
     * @return mixed
     */
    public function WhereOrCreate(array $values, array $attributes = null)
    {
        $query = $this->model;

        return $query->firstOrCreate($attributes ?? $values, $values);
    }

    /**
     * @param null $labelField
     * @param string $valueField
     * @param bool $applyOrder
     * @param string $orderBy
     * @param string $orderDir
     * @return mixed
     */
    public function findAllForFormSelect(
        $labelField = null,
        $valueField = 'id',
        $applyOrder = false,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    )
    {
        $query = $this->model;

        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        return $query->pluck($valueField, $labelField);
    }

    /**
     * @param $label
     * @param $value
     * @return mixed
     */
    public function pluck($label, $value)
    {
        $query = $this->model;

        return $query->pluck($label, $value);
    }

    /**
     * @param string[] $fields
     * @param boolean $applyOrder
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function findAll($fields = ['*'], $applyOrder = true, $orderBy = self::ORDER_BY, $orderDir = self::ORDER_DIR)
    {
        $query = $this->model;
        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        return $query->get($fields);
    }

    /**
     * @param array $filters
     * @param array $relations
     * @param bool $applyOrder
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @param array $extraOrderBy
     * @param array $extraOrderDir
     * @return mixed
     */
    public function search(
        $filters = [],
        $relations = [],
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR,
        $extraOrderBy = self::EXTRA_ORDER_BY,
        $extraOrderDir = self::EXTRA_ORDER_DIR
    )
    {
        $query = $this->model;

        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        // Merge default filters with requested filters
        $filters = array_merge($this->defaultFilters, $filters);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }

        return $this->getQueryResult(
            $query,
            $applyOrder,
            $page,
            $limit,
            $orderBy,
            $orderDir,
            $extraOrderBy,
            $extraOrderDir
        );
    }

    /**
     * @param            $query
     * @param bool $applyOrder
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @param array $extraOrderBy
     * @param array $extraOrderDir
     * @return mixed
     */
    public function getQueryResult(
        $query,
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR,
        $extraOrderBy = self::EXTRA_ORDER_BY,
        $extraOrderDir = self::EXTRA_ORDER_DIR
    )
    {
        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        if ($extraOrderBy) {
            for ($i = 0, $iMax = count($extraOrderBy); $i < $iMax; $i++) {
                $dir = $extraOrderDir[$i] ?: self::ORDER_DIR;
                $query = $query->orderBy($extraOrderBy[$i], $dir);
            }
        }

        if (config('app.query_debug')) {
            return $query->toSql();
        }

        if ($page) {
            return $query->paginate($limit);
        }

        if ($limit) {
            return $query->take($limit)->get();
        }

        return $query->get();
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchCount(
        $filters = []
    )
    {
        $query = $this->model;

        // Merge default filters with requested filters
        $filters = array_merge($this->defaultFilters, $filters);
        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }

        return $query->count();
    }

    /**
     * @param null $groupBy
     * @param array $fields
     * @param array $filters
     * @param array $relations
     * @param bool $applyOrder
     * @param bool|false $page
     * @param bool $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function searchBySelected(
        $groupBy = null,
        $fields = [],
        $filters = [],
        $relations = [],
        $applyOrder = false,
        $page = false,
        $limit = false,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    )
    {
        $query = $this->model;

        if (!empty($relations)) {
            $query = $query->with($relations);
        }

        if (!empty($filters)) {
            foreach ($this->model->getFilters() as $filter) {
                //if (isset($filters[$filter]) and !empty($filters[$filter])) {
                if (isset($filters[$filter])) {
                    $withFilter = "of" . ucfirst($filter);
                    $query = $query->$withFilter($filters[$filter]);
                }
            }
        }

        if (!empty($fields)) {
            $query = $query->selectRaw(implode(',', $fields));
        }

        if (!empty($groupBy)) {
            $query = $query->groupBy(implode(',', $groupBy));
        }

        if ($applyOrder) {
            $query = $query->orderBy($orderBy, $orderDir);
        }

        if ($page) {
            return $query->paginate($limit);
        }

        if ($limit) {
            return $query->take($limit)->get();
        }

        return $query->get();
    }

    /**
     * Create a Pagination From Items Of  array Or collection.
     *
     * @param array|Collection $items
     * @param int $perPage
     * @param int $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    /**
     * @param null $keyContains
     * @param false $returnCount
     * @return array|int
     * @throws ReflectionException
     */
    public static function getConstants($keyContains = null, $returnCount = false)
    {
        // Get all constants
        $model = app(get_called_class())->model;
        $constants = (new \ReflectionClass($model))->getConstants();
        // Return filtered constants based on constants names filter
        if (!empty($keyContains)) {
            $constants = array_filter($constants, function ($k) use ($keyContains) {
                return strpos($k, $keyContains) === 0;
            }, ARRAY_FILTER_USE_KEY);
        }

        if ($returnCount) {
            return count($constants);
        }

        return $constants;
    }

    /**
     * @param key
     *
     * @return mixed
     */
    public function last()
    {
        return $this->model->latest()->first();
    }

    /**
     * @param $scope
     * @return $this
     */
    public function withoutGlobalScope($scope)
    {
        return new $this($this->model::withoutGlobalScope($scope));
    }
}
