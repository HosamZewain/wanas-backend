<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\TripResource;
use App\Models\Trip;
use App\Models\TripMember;
use App\Repositories\SQL\TripRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends ApiBaseController
{

    private $tripRepository;

    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }


    public function tripsList(Request $request)
    {
        $filters['PickUpAddress'] = $request->pickup_address;
        $filters['DropOffAddress'] = $request->drop_off_address;
        $filters['Date'] = $request->date;
        $resources = $this->tripRepository->search($filters, ['user'], false, true, false);
        if ($resources) {
            $resources = TripResource::collection($resources);
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.error'));
    }

    public function createTrip(Request $request)
    {
        $messages = [
            'pickup_address.required' => 'نقطة الإنطلاق  مطلوبة',
            'drop_off_address.required' => 'نقطة الوصول  مطلوبة',
            'trip_date.required' => 'تاريخ الرحلة مطلوب',
            'trip_time.required' => 'وقت الرحلة مطلوب',
            'members_count.required' => 'عدد الأفراد  مطلوب',
            'trip_cost_per_person.required' => 'تكلفة الرحلة   مطلوبة',
        ];
        $validation = Validator::make($request->all(), [
            'pickup_address' => 'required',
            'drop_off_address' => 'required',
            'trip_date' => 'required',
            'trip_time' => 'required',
            'members_count' => 'required',
            'trip_cost_per_person' => 'required',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }


        $inputs = $request->all();
        $inputs['status'] = Trip::STATUS_ACTIVE;
        $inputs['user_id'] = $request->user()->id;
        $inputs['total_trip_cost'] = $request->members_count * $request->trip_cost_per_person;
        $resource = $this->tripRepository->create($inputs);
        if ($resource) {
            $resource = new TripResource($resource);
            //$this->IUserRepository->sendSMS($resource); // deprecated for using firebase otp
            return $this->respondWithSuccess(__('messages.register_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }


    public function bookTrip(Request $request)
    {
        $messages = [
            'trip_id.required' => 'رقم الرحلة مطلوبة',
        ];
        $validation = Validator::make($request->all(), [
            'trip_id' => 'required',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }


        $resource = $this->tripRepository->find($request->trip_id);
        if ($resource) {
            $resource->members()->create([
                'user_id' => $request->user()->id,
                'status' => TripMember::STATUS_WAITING_APPROVAL,
            ]);
            $resource = new TripResource($resource);
            return $this->respondWithSuccess(__('messages.request_sent_successfully'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }
}
