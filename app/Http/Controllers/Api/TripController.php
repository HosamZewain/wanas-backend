<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\TripResource;
use App\Models\Notification;
use App\Models\Trip;
use App\Models\TripMember;
use App\Repositories\SQL\NotificationRepository;
use App\Repositories\SQL\TripMemberRepository;
use App\Repositories\SQL\TripRateRepository;
use App\Repositories\SQL\TripRepository;
use App\Repositories\SQL\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class TripController extends ApiBaseController
{

    private $tripRepository;
    private $notificationRepository;
    private $tripMemberRepository;
    private $userRepository;
    private $tripRateRepository;

    public function __construct(TripRepository         $tripRepository,
                                NotificationRepository $notificationRepository,
                                userRepository         $userRepository,
                                TripRateRepository     $tripRateRepository,
                                TripMemberRepository   $tripMemberRepository)
    {
        $this->userRepository = $userRepository;
        $this->tripRateRepository = $tripRateRepository;
        $this->tripRepository = $tripRepository;
        $this->tripMemberRepository = $tripMemberRepository;
        $this->notificationRepository = $notificationRepository;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function tripsList(Request $request): JsonResponse
    {
    //    $filters['PickUpAddress'] = $request->pickup_address;
    //    $filters['DropOffAddress'] = $request->drop_off_address;
        $filters['Dates'] = [$request->FromDate, $request->ToDate];
        $filters['TripType'] = $request->type;
        $filters['GenderType'] = $request->gender;
        $filters['StatusByDate'] = Carbon::now();
        $filters['FromCityIdSearch'] = $request->from_city_id ?? '';
        $filters['ToCityIdSearch'] = $request->to_city_id ?? '';
        $filters['FromGovernorateId'] = $request->from_governorate_id ?? '';
        $filters['ToGovernorateId'] = $request->to_governorate_id ?? '';
        //  $filters['CountryId'] = $request->user()->country_id ?? null;

        $trips = $this->tripRepository->search($filters, ['user', 'attachments'], true, true, false);

        if ($trips) {
            $resources = TripResource::collection($trips);
            $resources = new LengthAwarePaginator($resources, $trips->total(), $trips->perPage());
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.error'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createTrip(Request $request): JsonResponse
    {
        $tripName = 'الفعالية';
        if ($request->get('trip_type') && $request->trip_type == Trip::TYPE_RIDE) {
            $tripName = 'الرحلة';
        }
        $messages = [
            'pickup_address.required' => 'نقطة الإنطلاق  مطلوبة',
            'drop_off_address.required' => 'نقطة الوصول  مطلوبة',
            'trip_date.required' => 'تاريخ ' . $tripName . ' مطلوب',
            'trip_time.required' => 'وقت ' . $tripName . ' مطلوب',
            'members_count.required' => 'عدد الأفراد  مطلوب',
            'trip_cost_per_person.required' => 'تكلفة ' . $tripName . '   مطلوبة',
        ];
        $validation = Validator::make($request->all(), [
            'pickup_address' => 'required',
            'drop_off_address' => 'required',
            'trip_date' => 'required',
            'trip_time' => 'required',
            'members_count' => 'required',
            'trip_cost_per_person' => 'required',
            'trip_type' => 'required',
            'trip_name' => 'required_if:trip_type,' . Trip::TYPE_EVENT,
            'trip_details' => 'required_if:trip_type,' . Trip::TYPE_EVENT,
            'trip_vehicle_type' => 'required_if:trip_type,' . Trip::TYPE_EVENT,
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
            if (!empty($request->images)) {
                foreach ($request->images as $image) {
                    $path = $image->store('trips', 'public');
                    $resource->attachments()->create([
                        'attachment_url' => 'trips/' . basename($path),
                        'original_name' => $image->getClientOriginalName(),
                        'file_type' => $image->getMimeType(),
                        'key' => 'trips_images'
                    ]);
                }
            }
            $resource = new TripResource($resource);
            return $this->respondWithSuccess(__('messages.trip_added_success', ['name' => $tripName]), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function bookTrip(Request $request): JsonResponse
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


        $resource = $this->tripRepository->find($request->trip_id, ['user.fcmTokens', 'ApprovedMembers']);
        if ($resource) {
            //check members count
            if ($resource->members_count <= $resource->members()->where('status', TripMember::STATUS_APPROVED)->count()) {
                return $this->respondWithErrors(__('messages.trip_complete'), 422, null, __('messages.trip_complete'));
            }


            $filters['UserId'] = $request->user()->id;
            $filters['TripId'] = $resource->id;
            $check = $this->tripMemberRepository->search($filters, [], false, false, false);
            if (count($check)) {
                return $this->respondWithErrors(__('messages.booked_before'), 422, null, __('messages.booked_before'));
            }
            //create trip
            $this->tripMemberRepository->create([
                'user_id' => $request->user()->id,
                'trip_id' => $resource->id,
                'status' => TripMember::STATUS_WAITING_APPROVAL,
            ]);


            $title = 'وصلك إشعار جديدة بحجز رحلة جديدة';
            $body = "طلب حجز على الرحلة رقم {$resource->id}";
            $parameters['type'] = Notification::TYPE_NEW_BOOK;
            $parameters['member_id'] = $request->user()->id;
            $parameters['model_id'] = $resource->id;
            $parameters['model_type'] = get_class($resource);
            $this->notificationRepository->sendNotification($resource->user, $body, $title, $parameters);
            $resource = new TripResource($resource);
            return $this->respondWithSuccess(__('messages.request_sent_successfully'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function tripDetails(Request $request): JsonResponse
    {
        $resource = $this->tripRepository->find($request->trip_id, ['user', 'user.vehicle.carFront', 'user.vehicle.carNear', 'user.vehicle.carBack', 'members']);
        if ($resource) {

            //    dd($resource);
            $resource = new TripResource($resource);
            return $this->respondWithSuccess(__('messages.data_found'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.no_data_found'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function acceptMember(Request $request): JsonResponse
    {
        $messages = [
            'trip_id.required' => 'رقم الرحلة مطلوبة',
            'member_id.required' => 'المستخدم مطلوب',
        ];
        $validation = Validator::make($request->all(), [
            'trip_id' => 'required',
            'member_id' => 'required',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }
        $resource = $this->tripRepository->find($request->trip_id, ['user']);
        if ($resource) {
            $member = $this->userRepository->find($request->member_id, ['fcmTokens']);
            if ($member) {

                $filters['TripId'] = $resource->id;
                $filters['UserId'] = $member->id;
                $tripMember = $this->tripMemberRepository->search($filters, [], false, false, false);
                if (count($tripMember)) {
                    if ($tripMember->first()->status != TripMember::STATUS_WAITING_APPROVAL) {
                        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
                    }
                    $this->tripMemberRepository->update($tripMember->first(), [
                        'status' => TripMember::STATUS_APPROVED,
                    ]);

                    $title = 'تم تأكيد  حجز الرحلة ';
                    $body = " تم تأكيد حجز الرحلة $resource->trip_name ";
                    $parameters['type'] = Notification::TYPE_BOOK_APPROVED;
                    $parameters['member_id'] = $request->user()->id;
                    $parameters['model_id'] = $member->id;
                    $parameters['model_type'] = get_class($member);
                    $this->notificationRepository->sendNotification($member, $body, $title, $parameters);
//                $title = 'تم الموافقة على حجز الرحلة';
//                $body = 'طلب حجز على الرحلة رقم .' . $resource->id;
//                $parameters['type'] = 'book_approved';
//                $parameters['model_id'] = $resource->id;
//                $parameters['model_type'] = get_class($resource);
//                $member = $this->userRepository->find($member->id, ['fcmTokens']);
//                $this->notificationRepository->sendNotification($member, $body, $title, $parameters);
                    $resource = new TripResource($resource);
                    return $this->respondWithSuccess(__('messages.book_approved'), $resource);
                }
            }
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectMember(Request $request)
    {
        $messages = [
            'trip_id.required' => 'رقم الرحلة مطلوبة',
            'member_id.required' => 'المستخدم مطلوب',
        ];
        $validation = Validator::make($request->all(), [
            'trip_id' => 'required',
            'member_id' => 'required',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }
        $resource = $this->tripRepository->find($request->trip_id, ['user']);
        if ($resource->user_id == $request->user()->id) {
            $member = $resource->members->where('user_id', $request->member_id)->first();
            if ($member) {
                $member->update([
                    'status' => TripMember::STATUS_DISAPPROVED,
                ]);
                $title = 'تم رفض طلبك على حجز الرحلة';
                $body = 'تم رفض طلبك   على  حجز الرحلة رقم .' . $resource->id;
                $parameters['type'] = 'book_disapproved';
                $parameters['model_id'] = $resource->id;
                $parameters['member_id'] = $resource->user_id;
                $parameters['model_type'] = get_class($resource);

                $member = $this->userRepository->find($request->member_id, ['fcmTokens']);
                $this->notificationRepository->sendNotification($member, $body, $title, $parameters);
                $resource = new TripResource($resource);
                return $this->respondWithSuccess(__('messages.book_disapproved'), $resource);
            }
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function rateTrip(Request $request)
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
        $resource = $this->tripRepository->find($request->trip_id, ['user']);
        if ($resource) {
            $this->tripRateRepository->create([
                'user_id' => $request->user()->id,
                'trip_id' => $resource->id,
                'rate' => $request->rate,
                'comment' => $request->comment
            ]);
            $filters['TripId'] = $resource->id;
            $CustomersRates = $this->tripRateRepository->search($filters, [], false, false, false);
            $CustomersRates = $CustomersRates->AVG('rate');
            if (isset($CustomersRates)) {
                $resource->update(['rate' => $CustomersRates]);
            }
            $resource = new TripResource($resource);
            return $this->respondWithSuccess(__('messages.book_disapproved'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }
}
