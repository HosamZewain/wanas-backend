<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\UserVehicleResource;
use App\Models\UserVehicle;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\UserVehicleRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends ApiBaseController
{

    private $vehicleTypeRepository;
    private $userVehicleRepository;
    private $IUserRepository;

    /**
     * VehicleController constructor.
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @param UserVehicleRepository $userVehicleRepository
     */
    public function __construct(VehicleTypeRepository $vehicleTypeRepository,
                                UserVehicleRepository $userVehicleRepository)
    {
        $this->IUserRepository = app(UserRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->userVehicleRepository = $userVehicleRepository;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addVehicle(Request $request)
    {
        $messages = [
            'color.required' => ' اللون مطلوب',
            'number.required' => ' رقم السيارة مطلوب',
            'model.required' => ' موديل السيارة مطلوب',
            'type.required' => ' نوع السيارة مطلوب',
            'images.required' => ' صورة السيارة مطلوبة',
        ];
        $validation = Validator::make($request->all(), [
            'color' => 'required',
            'number' => 'required',
            'model' => 'required',
            'type' => 'required|exists:vehicle_types,id',
            'images' => 'required|array',
            'images.*' => 'required|image',
            'car_license_front' => 'required|image',
            'car_license_back' => 'required|image',
            'driver_license_front' => 'required|image',
            'driver_license_back' => 'required|image',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        if (!empty($request->user()->vehicle()->first())) {
            return $this->respondWithErrors( __('messages.cannot_add_more_than_one_vehicle'), 422, null, __('messages.cannot_add_more_than_one_vehicle'));
        }
        $inputs = $request->all();
        $inputs['user_id'] = $request->user()->id;
        $inputs['status'] = UserVehicle::STATUS_IN_PROGRESS;
        $resource = $this->userVehicleRepository->create($inputs);
        if ($resource) {
            if (!empty($request->images)) {
                foreach ($request->images as $image) {
                    $path = $image->store('vehicles', 'public');
                    $resource->attachments()->create([
                        'attachment_url' => 'vehicles/' . basename($path),
                        'original_name' => $image->getClientOriginalName(),
                        'file_type' => $image->getMimeType(),
                        'key' => 'vehicle_images'
                    ]);
                }
            }
            if ($request->hasFile('car_license_front')) {
                $resource->update(['car_license_front' => $request->file('car_license_front')->store('vehicles', 'public'),]);
            }
            if ($request->hasFile('car_license_back')) {
                $resource->update(['car_license_back' => $request->file('car_license_back')->store('vehicles', 'public'),]);
            }
            if ($request->hasFile('driver_license_front')) {
                $resource->update(['driver_license_front' => $request->file('driver_license_front')->store('vehicles', 'public'),]);
            }
            if ($request->hasFile('driver_license_back')) {
                $resource->update(['driver_license_back' => $request->file('driver_license_back')->store('vehicles', 'public'),]);
            }
            $resource->save();
            $resource = new UserVehicleResource($resource);
            return $this->respondWithSuccess(__('messages.added_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
            'images.*' => 'nullable|image',
            'car_license_front' => 'nullable|image',
            'car_license_back' => 'nullable|image',
            'driver_license_front' => 'nullable|image',
            'driver_license_back' => 'nullable|image',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $inputs = $request->all();
        $inputs['user_id'] = $request->user()->id;
        $resource = $this->userVehicleRepository->find($request->vehicle_id);
        $resource = $this->userVehicleRepository->update($resource,$inputs);
        if ($resource) {
            if (!empty($request->images)) {
                foreach ($request->images as $image) {
                    $path = $image->store('vehicles', 'public');
                    $resource->attachments()->create([
                        'attachment_url' => 'vehicles/' . basename($path),
                        'original_name' => $image->getClientOriginalName(),
                        'file_type' => $image->getMimeType(),
                        'key' => 'vehicle_images'
                    ]);
                }
            }
            if ($request->hasFile('car_license_front')) {
                $resource->update(['car_license_front' => $request->file('car_license_front')->store('vehicles', 'public'),]);
            }
            if ($request->hasFile('car_license_back')) {
                $resource->update(['car_license_back' => $request->file('car_license_back')->store('vehicles', 'public'),]);
            }
            if ($request->hasFile('driver_license_front')) {
                $resource->update(['driver_license_front' => $request->file('driver_license_front')->store('vehicles', 'public'),]);
            }
            if ($request->hasFile('driver_license_back')) {
                $resource->update(['driver_license_back' => $request->file('driver_license_back')->store('vehicles', 'public'),]);
            }
            $resource->save();
            $resource = new UserVehicleResource($resource);
            return $this->respondWithSuccess(__('messages.edit_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }
}
