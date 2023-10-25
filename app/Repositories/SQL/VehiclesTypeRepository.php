<?php

namespace App\Repositories\SQL;

use App\Models\VehiclesType;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\VehiclesTypeContract;

class VehiclesTypeRepository extends BaseRepository implements VehiclesTypeContract
{
    /**
     * VehiclesTypeRepository constructor.
     * @param VehiclesType $model
     */
    public function __construct(VehiclesType $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = []): mixed
    {
        $vehicleType = parent::create($attributes);
        
        if (isset($attributes['logo'])) {

            foreach ($attributes['logo'] as $logo) {

                saveFileByRelation($vehicleType, $logo['id'], 'logo');
            }
        }

        return $vehicleType->refresh();
    }

    public function remove(Model $model): mixed
    {
        $model->logo->delete();
        parent::remove($model);
        return $model->delete();
    }
}
