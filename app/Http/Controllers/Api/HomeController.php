<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\VehicleTypeResource;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Carbon\Carbon;

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


    public function tripFilters()
    {
        setLocale(LC_TIME, 'ar');

        $list = [];
        $period = (new \Carbon\CarbonPeriod)->locale('ar')->create(Carbon::today(), Carbon::today()->addDays(5));
        foreach ($period as $date) {
            $list[$date->format('Y-m-d')] = __('messages.days_array')[$date->format('D')];
        }
        // Convert the period to an array of dates
        return $list;
    }
}
