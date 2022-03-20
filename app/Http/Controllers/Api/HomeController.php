<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\CityResource;
use App\Http\Resources\Api\CountryResource;
use App\Http\Resources\Api\GovernorateResource;
use App\Http\Resources\Api\VehicleTypeResource;
use App\Models\Notification;
use App\Models\UserFcmToken;
use App\Repositories\SQL\AttachmentRepository;
use App\Repositories\SQL\CityRepository;
use App\Repositories\SQL\ColorRepository;
use App\Repositories\SQL\ContactUsRepository;
use App\Repositories\SQL\CountryRepository;
use App\Repositories\SQL\GovernorateRepository;
use App\Repositories\SQL\NotificationRepository;
use App\Repositories\SQL\PageRepository;
use App\Repositories\SQL\SettingRepository;
use App\Repositories\SQL\TripRepository;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class HomeController extends ApiBaseController
{

    public $IUserRepository;
    private $vehicleTypeRepository;
    private $contactUsRepository;
    private $pageRepository;
    private $settingRepository;
    private $countryRepository;
    private $colorRepository;
    private $notificationRepository;
    private $cityRepository;
    private $governorateRepository;
    private $INotificationRepository;
    private $tripRepository;
    private $userRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository,
                                CountryRepository     $countryRepository,
                                ContactUsRepository   $contactUsRepository)
    {
        $this->settingRepository = app(SettingRepository::class);
        $this->IUserRepository = app(UserRepository::class);
        $this->pageRepository = app(PageRepository::class);
        $this->countryRepository = $countryRepository;
        $this->colorRepository = app(ColorRepository::class);
        $this->notificationRepository = app(NotificationRepository::class);
        $this->governorateRepository = app(GovernorateRepository::class);
        $this->cityRepository = app(CityRepository::class);
        $this->tripRepository = app(TripRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->contactUsRepository = $contactUsRepository;
    }

    public function doSomeStuff()
    {
        $users = $this->IUserRepository->search([], [], [], false, false, false);
        foreach ($users as $resource) {
            if ($resource->profile_image) {
                app(AttachmentRepository::class)->specialUpload($resource->profile_image, $resource, 'profile_image', 'user');
            }
            if ($resource->civil_image_front) {
                app(AttachmentRepository::class)->specialUpload($resource->civil_image_front, $resource, 'civil_image_front', 'user');
            }
            if ($resource->civil_image_back) {
                app(AttachmentRepository::class)->specialUpload($resource->civil_image_back, $resource, 'civil_image_back', 'user');
            }
        }

    }

    public function index(): string
    {
        return 'documentation';
    }

    public function pages(): JsonResponse
    {
        $resources = $this->pageRepository->search([], [], false, false);
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function countries(): JsonResponse
    {
        $resources = $this->countryRepository->search([], [], true, false, false, 'name_ar', 'ASC');
        if ($resources) {
            $resources = CountryResource::collection($resources);


        //    $resources = new LengthAwarePaginator($resources, $notifications->total(), $notifications->perPage());
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function colors(): JsonResponse
    {
        $resources = $this->colorRepository->search([], [], false, false, false);
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function governorates(Request $request): JsonResponse
    {
        $filters['CountryId'] = $request->country_id;
        $resources = $this->governorateRepository->search($filters, [], false, false, false);
        if ($resources) {
            $resources = GovernorateResource::collection($resources);
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function cities(Request $request): JsonResponse
    {
        $filters['CountryId'] = ($request->user() !== null)  ? $request->user()->country_id : null;
        $filters['GovernorateId'] = $request->governorate_id;
        $filters['Keyword'] = $request->keyword;
        $resources = $this->cityRepository->search($filters, [], false, false, false);
        if ($resources) {
            $resources = CityResource::collection($resources);
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function addCity(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'governorates_id' => 'required',
        ]);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $inputs = $request->all();
        $resource = $this->cityRepository->create($inputs);
        if ($resource) {
            $resources = new CityResource($resource);
            return $this->respondWithSuccess(__('messages.added_success'), $resources);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function page($id)
    {
        $resources = $this->pageRepository->find($id);
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function termsConditions()
    {
        $resources = $this->settingRepository->search([], [], false, false)->first()->terms_conditions;
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function setting()
    {
        $resources = $this->settingRepository->search([], [], false, false)->first();
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function VehicleTypes()
    {
        $resources = $this->vehicleTypeRepository->search([], [], false, false, false);
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
        $period = (new \Carbon\CarbonPeriod)->locale('ar')->create(Carbon::today(), Carbon::today()->addDays(6));
        foreach ($period as $date) {
            $list[$date->format('Y-m-d')] = __('messages.days_array')[$date->format('D')];
        }
        // Convert the period to an array of dates
        return $list;
    }

    public function contactUs(Request $request)
    {
        $messages = [
            'subject.required' => ' عنوان الرسالة مطلوب',
            'name.required' => ' الإسم مطلوب  مطلوب',
            'email.required' => ' البريد الإلكترونى مطلوب',
            'mobile.required' => ' رقم الهاتف المحمول  مطلوب',
            'body.required' => ' محتوى الرسالة  مطلوب',
        ];
        $validation = Validator::make($request->all(), [
            'subject' => 'required|string',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'mobile' => 'required',
            'body' => 'required',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }
        $inputs = $request->all();
        $resource = $this->contactUsRepository->create($inputs);
        if ($resource) {
            return $this->respondWithSuccess(__('messages.added_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function refresh(Request $request): JsonResponse
    {
        if (auth('sanctum')->check()) {
            $resource = $request->user();
            //  $request->user()->tokens()->delete();
            $token = $resource->createToken('auth_token')->plainTextToken;
            $resource['access_token'] = $token;
            return $this->respondWithSuccess(__('messages.added_success'), $resource);
        }

        if ($request->get('mobile')) {
            $resource = $this->IUserRepository->findBy('mobile', $request->mobile);
            if ($resource) {
                $token = $resource->createToken('auth_token')->plainTextToken;
                $resource['access_token'] = $token;
                $resource['token_type'] = 'Bearer';
                return $this->respondWithSuccess(__('messages.added_success'), $resource);
            }

            return $resource;
        }

    }

    public function sendFcm(Request $request)
    {
            $parameters = $request->all();
            if (isset($parameters['trip_id'])) {
                $trip = $this->tripRepository->find($parameters['trip_id'], ['ApprovedMembers']);
                if (!empty($trip->ApprovedMembers)) {
                    foreach ($trip->ApprovedMembers as $member) {
                        $parameters['trip'] = $trip;
                        $user = $this->IUserRepository->find($member->user_id);
                        $this->notificationRepository->sendNotificationApi($user, $parameters);
                    }
                    return $this->respondWithSuccess(__('messages.added_success'), $trip);
                }
            }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }
}
