<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\UserVehicleResource;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\UserVehicleRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends ApiBaseController
{

    private $vehicleTypeRepository;
    private $userVehicleRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository, UserVehicleRepository $userVehicleRepository)
    {
        $this->IUserRepository = app(UserRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->userVehicleRepository = $userVehicleRepository;
    }


    public function addVehicle(Request $request)
    {
        $messages = [
            'color.required' => ' اللون مطلوب',
            'number.required' => ' رقم السيارة مطلوب',
            'model.required' => ' موديل السيارة مطلوب',
            'type.required' => ' نوع السيارة مطلوب',
            'image.required' => ' صورة السيارة مطلوبة',
        ];
        $validation = Validator::make($request->all(), [
            'color' => 'required',
            'number' => 'required',
            'model' => 'required',
            'type' => 'required|exists:vehicle_types,id',
            'image' => 'required|image',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        if (!empty($request->user()->vehicle()->first())) {
            return $this->respondWithErrors( __('messages.cannot_add_more_than_one_vehicle'), 422, null, __('messages.cannot_add_more_than_one_vehicle'));
        }
        $inputs = $request->all();
        $inputs['user_id'] = $request->user()->id;
        $resource = $this->userVehicleRepository->create($inputs);
        if ($resource) {
            if ($request->hasFile('image')) {
                $resource->update(['image' => $request->file('image')->store('vehicles', 'public'),]);
            }
            $resource->save();
            $resource = new UserVehicleResource($resource);
            return $this->respondWithSuccess(__('messages.added_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function editVehicle(Request $request)
    {
        $messages = [
            'color.required' => ' اللون مطلوب',
            'number.required' => ' رقم السيارة مطلوب',
            'model.required' => ' موديل السيارة مطلوب',
            'type.required' => ' نوع السيارة مطلوب',
            'image.required' => ' صورة السيارة مطلوبة',
            'vehicle_id.required' => ' رقم معرف السيارة مطلوب',
            'vehicle_id.exists' => ' رقم معرف السيارة غير مسجل من قبل',
        ];
        $validation = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:user_vehicle,id',
            'color' => 'nullable',
            'number' => 'nullable',
            'model' => 'nullable',
            'type' => 'nullable|exists:vehicle_types,id',
            'image' => 'nullable|image',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $inputs = $request->all();
        $inputs['user_id'] = $request->user()->id;
        $resource = $this->userVehicleRepository->find($request->vehicle_id);
        $resource = $this->userVehicleRepository->update($resource,$inputs);
        if ($resource) {
            if ($request->hasFile('image')) {
                $resource->update(['image' => $request->file('image')->store('vehicles', 'public'),]);
            }
            $resource->save();
            $resource = new UserVehicleResource($resource);
            return $this->respondWithSuccess(__('messages.edit_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }
}
