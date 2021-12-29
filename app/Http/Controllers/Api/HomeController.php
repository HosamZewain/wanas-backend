<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\VehicleTypeResource;
use App\Models\UserFcmToken;
use App\Repositories\SQL\ColorRepository;
use App\Repositories\SQL\ContactUsRepository;
use App\Repositories\SQL\CountryRepository;
use App\Repositories\SQL\PageRepository;
use App\Repositories\SQL\SettingRepository;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends ApiBaseController
{

    public $IUserRepository;
    private $vehicleTypeRepository;
    private $contactUsRepository;
    private $pageRepository;
    private $settingRepository;
    private $countryRepository;
    /**
     * @var Application|mixed
     */
    private $colorRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository,
                                CountryRepository $countryRepository,
                                ContactUsRepository   $contactUsRepository)
    {
        $this->settingRepository = app(SettingRepository::class);
        $this->IUserRepository = app(UserRepository::class);
        $this->pageRepository = app(PageRepository::class);
        $this->countryRepository = $countryRepository;
        $this->colorRepository = app(ColorRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->contactUsRepository = $contactUsRepository;
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
        $resources = $this->countryRepository->search([], [], true, false,false,'name_ar','ASC');
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }
    public function colors(): JsonResponse
    {
        $resources = $this->colorRepository->search([], [], false, false,false);
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
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
        $resources = $this->settingRepository->search([],[],false,false)->first()->terms_conditions;
        if ($resources) {
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.no_data_found'));
    }

    public function setting()
    {
        $resources = $this->settingRepository->search([],[],false,false)->first();
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
        $period = (new \Carbon\CarbonPeriod)->locale('ar')->create(Carbon::today(), Carbon::today()->addDays(5));
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
}
