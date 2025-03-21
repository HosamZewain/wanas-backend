<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\TripResource;
use App\Http\Resources\Api\UserRateResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\UserVehicleResource;
use App\Repositories\SQL\UserRateRepository;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\UserVehicleRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiBaseController
{

    private $vehicleTypeRepository;
    private $userVehicleRepository;
    private $IUserRepository;
    private $userRepository;
    private $userRateRepository;

    /**
     * VehicleController constructor.
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @param UserVehicleRepository $userVehicleRepository
     */
    public function __construct(VehicleTypeRepository $vehicleTypeRepository,
                                UserVehicleRepository $userVehicleRepository)
    {
        $this->userRepository = app(UserRepository::class);
        $this->userRateRepository = app(UserRateRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->userVehicleRepository = $userVehicleRepository;
    }


    public function rateUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $user = $this->userRepository->find($request->user_id);
        if ($user) {
            $userRateFilters['UserId'] = $request->user()->id;
            $userRateFilters['UserRateId'] = $request->user_id;
            $check = $this->userRateRepository->search($userRateFilters, [], false, false, false);
            if (count($check)) {
                $this->userRateRepository->update($check->first(), [
                    'rate' => $request->rate,
                    'comment' => $request->comment,
                ]);
            } else {
                $check = $this->userRateRepository->create([
                    'user_id' => $request->user()->id,
                    'rate_user_id' => $user->id,
                    'rate' => $request->rate,
                    'comment' => $request->comment,
                ]);
            }


            $filters['UserRateId'] = $user->id;
            $CustomersRates = $this->userRateRepository->search($filters, [], false, true, false);
            if (isset($CustomersRates)) {
                $CustomersRates = $CustomersRates->AVG('rate');
                $this->userRepository->update($user, ['rate' => $CustomersRates]);
            }

            $CustomersRates = $this->userRateRepository->search($filters, [], false, true, false);
            $resources = UserRateResource::collection($CustomersRates);
            $resources = new LengthAwarePaginator($resources, $CustomersRates->total(), $CustomersRates->perPage());
            return $this->respondWithSuccess(__('dashboard.created_successfully'), $resources);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function userDetails(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $user = $this->userRepository->find($request->user_id, ['rates', 'vehicle.attachments']);
        $user = new UserResource($user);
        return $this->respondWithSuccess(__('messages.data_found'), $user);
    }

    public function getUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => 'required|exists:users,mobile',
        ]);
        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $user = $this->userRepository->findBy('mobile', $request->mobile);
        if ($user){
            $user = new UserResource($user);
            return $this->respondWithSuccess(__('messages.data_found'), $user);
        }
        return $this->respondWithErrors(__('messages.error'), 400, null, __('messages.no_data_found'));
    }


}
