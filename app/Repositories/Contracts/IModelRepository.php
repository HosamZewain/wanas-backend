<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IModelRepository
{
    public const LIMIT = 10;
    public const ORDER_BY = 'id';
    public const ORDER_DIR = 'DESC';
    public const EXTRA_ORDER_BY = [];
    public const EXTRA_ORDER_DIR = [];


    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Model $model, $attributes = []);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateAll($attributes = []);

    /**
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function createOrUpdate($attributes = [], $id = null);

    /**
     * @param array $searchIn
     * @param array $attributes
     * @return mixed
     */
    public function UpdateOrCreate(array $searchIn = [], array $attributes = []);

    /**
     * @param Model $model
     *
     * @return mixed
     */
    public function remove(Model $model);

    /**
     * @param int $id
     * @param array $relations
     *
     * @return mixed
     */
    public function find(int $id, array $relations = []);

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function findBy($key, $value);

    /**
     * @param mixed $fields
     *
     * @return mixed
     */
    public function findByFields(array $fields);

    /**
     * @param array $wheres
     * @param array|null $data
     * @return mixed
     */
    public function WhereOrCreate(array $wheres, array $data = null);

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
    );

    /**
     * @param $label
     * @param $value
     * @return mixed
     */
    public function pluck($label, $value);

    /**
     * @param boolean $applyOrder
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function findAll($fields = [], $applyOrder = true, $orderBy = self::ORDER_BY, $orderDir = self::ORDER_DIR);

    /**
     * @param array $filters
     * @param array $relations
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function search(
        $filters = [],
        $relations = [],
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    );

    /**
     * @param array $filters
     * @return mixed
     */
    public function searchCount(
        $filters = []);

    /**
     * @param            $query
     * @param bool $applyOrder
     * @param bool|false $page
     * @param int $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function getQueryResult(
        $query,
        $applyOrder = true,
        $page = true,
        $limit = self::LIMIT,
        $orderBy = self::ORDER_BY,
        $orderDir = self::ORDER_DIR
    );

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
    public function paginate($items, $perPage = 15, $page = null, $options = []);

    public static function getConstants($keyContains = null, $returnCount = false);

    public function withoutGlobalScope($scope);
}
