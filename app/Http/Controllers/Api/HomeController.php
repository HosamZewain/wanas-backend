<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\VehicleTypeResource;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\VehicleTypeRepository;

class HomeController extends ApiBaseController
{

    public $IUserRepository;
    private $vehicleTypeRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository)
    {
        $this->IUserRepository = app(UserRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
    }

    public function index()
    {
        return 'documentation';
    }

    public function VehicleTypes()
    {
        $resources = $this->vehicleTypeRepository->search([], [], false, false);
        if ($resources) {
            $resources = VehicleTypeResource::collection($resources);
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }
}
