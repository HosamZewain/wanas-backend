<?php

namespace App\Traits;

use ReflectionClass;
use ReflectionException;

trait ModelTrait
{
    /**
     * Get filters list
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters ?? [];
    }

    /**
     * Get defined relations list
     *
     * @return array
     */
    public function getDefinedRelations()
    {
        return $this->definedRelations ?? [];
    }

    /**
     * @param $relation
     * @param array $options
     */
    public function syncOneToMany($relation, $options = [])
    {
        $oldOptionsIDs = [];
        // create new options
        $newOptions = [];
        foreach ($options as $option) {
            if (!isset($option['id'])) {
                $newOptions[] = $this->$relation()->getModel()->newInstance($option);
            } else {
                $oldOptionsIDs[] = $option['id'];
            }
        }

        // delete removed options
        $allOptionsIDs = $this->$relation->lists('id');
        $allOptionsIDs = $allOptionsIDs->all();
        if (!empty($allOptionsIDs)) {
            $removedOptionsIDs = array_diff($allOptionsIDs, $oldOptionsIDs);
            $this->$relation()->whereIn('id', $removedOptionsIDs)->delete();
        }

        // save new options after delete removed options
        $this->$relation()->saveMany($newOptions);
    }

    /**
     * Get constants list of the class
     *
     * @param string $keyContains
     * @param boolean $returnCount
     * @return array|int
     */
    public static function getConstants($keyContains = null, $returnCount = false)
    {
        // Get all constants
        $constants = (new ReflectionClass(static::class))->getConstants();

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
     * Get relations method of the class
     *
     * @return array
     */
    public static function getRelationsMethods($namesOnly = false)
    {
        $relations = [];
        // Get all methods
        $methods = (new ReflectionClass(static::class))->getMethods();

        // Return  relations methods only
        foreach ($methods as $reflectionMethod) {
            $returnType = $reflectionMethod->getReturnType();

            if ($returnType) {
                if (in_array(
                    class_basename($returnType->getName()),
                    [
                        'HasOne', 'HasMany', 'BelongsTo', 'BelongsToMany', 'MorphToMany', 'MorphTo'
                    ]
                )) {
                    if ($namesOnly) {
                        $reflectionMethod = $reflectionMethod->getName();
                    }

                    $relations[] = $reflectionMethod;
                }
            }
        }

        return $relations;
    }
}
