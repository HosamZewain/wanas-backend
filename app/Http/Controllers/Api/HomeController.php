<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\VehicleTypeResource;
use App\Repositories\SQL\ContactUsRepository;
use App\Repositories\SQL\UserRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends ApiBaseController
{

    public $IUserRepository;
    private $vehicleTypeRepository;
    private $contactUsRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository, ContactUsRepository $contactUsRepository)
    {
        $this->IUserRepository = app(UserRepository::class);
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->contactUsRepository = $contactUsRepository;
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
}
