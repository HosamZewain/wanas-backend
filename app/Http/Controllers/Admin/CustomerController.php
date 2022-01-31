<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\Attachment;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\SQL\AttachmentRepository;
use App\Repositories\SQL\CountryRepository;
use App\Repositories\SQL\NotificationRepository;
use App\Repositories\SQL\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    private $userRepository;
    private $notificationRepository;
    private $attachmentRepository;
    private $countryRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->notificationRepository = app(NotificationRepository::class);
        $this->attachmentRepository = app(AttachmentRepository::class);
        $this->countryRepository = app(CountryRepository::class);
    }

    public function index(Request $request)
    {
        $filters['Type'] = User::TYPE_USER;
        $filters['UnConfirmed'] = $request->unconfirmed;
        $resources = $this->userRepository->search($filters, [], true, true);
        return view('dashboard.customers.index', compact('resources'));
    }

    public function create()
    {
        $countries = $this->countryRepository->search([], [], true, true);
        return view('dashboard.customers.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|string|unique:users,mobile',
            'password' => 'required|string|min:4',
            'email' => 'required|string|email|unique:users,email',
        ]);

        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->password);
        $inputs['type'] = User::TYPE_USER;
        $this->userRepository->create($inputs);
        flash(trans('dashboard.created_successfully'), 'green');

        return redirect()->to(route('customers.index'));
    }

    public function edit($id)
    {
        $resource = $this->userRepository->find($id);
        $countries = $this->countryRepository->search([], [], true, true);
        return view('dashboard.customers.edit', compact('resource','countries'));
    }
    public function show($id)
    {
        $resource = $this->userRepository->find($id);


        $countries = $this->countryRepository->search([], [], true, true);
        return view('dashboard.customers.show', compact('resource','countries'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $resource = $this->userRepository->find($id);

        $inputs = $request->all();
        $inputs['password'] = ($request->password) ? Hash::make($request->password) : $resource->password;
        $resource->update($inputs);
        flash(trans('dashboard.updated_successfully'), 'success');
        return redirect()->to(route('customers.index'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->userRepository->find($id);
        $resource->delete();

        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }


    /*********8ajax ************/

    public function confirmForm($id)
    {
        $data = $this->userRepository->find($id, ['attachments']);


        $resource = new UserResource($data);

        $view = view('dashboard.customers.partials._confirm', compact('resource'))->render();
        return response()->json(['msg' => trans('dashboard.deleted_successfully'), 'data' => $view]);
    }

    public function changeStatusAttachment(Request $request): JsonResponse
    {
        $file = $this->attachmentRepository->find($request->id);

        if ($file) {
            $fileName = __('enums.attachment_keys')[$file->key];
            $this->attachmentRepository->update($file, [
                'status' => ($request->status == 'approve') ? Attachment::STATUS_APPROVED : Attachment::STATUS_DISAPPROVED,
                'status_text' => $request->statusText,
            ]);
            $user = $this->userRepository->find($request->userId, ['fcmTokens']);
            if ($user && !$user->UnConfirmed) {
                $this->userRepository->update($user, [
                    'status' => User::ACTIVE,
                    'is_verified' => true,
                ]);

                if (count($user->fcmTokens)) {
                    $title = 'تم تأكيد بياناتك ';
                    $body = "تم تأكيد بياناتك بنجاح ، يمكنك ألإن حجز الرحلات المفضلة لديك";
                    $parameters['type'] = Notification::TYPE_CONFIRM_USER;
                    $parameters['member_id'] = $request->user()->id;
                    $parameters['model_id'] = $user->id;
                    $parameters['model_type'] = get_class($user);
                    $this->notificationRepository->sendNotification($user, $body, $title, $parameters);
                }
                return response()->json(['msg' => trans('dashboard.data_confirmed'), 'data' => $file], 200);
            }
            if ($user && $request->status == 'disapprove' && count($user->fcmTokens)) {
                $title = __('dashboard.attachment_disapproved', ['name' => $fileName, 'username' => $user->name]);
                $body = __('dashboard.attachment_disapproved_body', ['name' => $fileName, 'notes' => $request->statusText]);
                $parameters['type'] = Notification::TYPE_BOOK_DISAPPROVED;
                $parameters['member_id'] = $request->user()->id;
                $parameters['model_id'] = $user->id;
                $parameters['model_type'] = get_class($user);
                $this->notificationRepository->sendNotification($user, $body, $title, $parameters);
                return response()->json(['msg' => trans('dashboard.un_confirm_attachments', ['name' => $fileName]), 'data' => $file], 200);
            }

//            if ($user && $request->status == 'approve' && count($user->fcmTokens)) {
//                $title = __('dashboard.attachment_approved', ['name' => $fileName, 'username' => $user->name]);
//                $body = __('dashboard.attachment_approved_body', ['name' => $fileName, 'notes' => $request->statusText]);
//                $parameters['type'] = Notification::TYPE_CONFIRM_USER;
//                $parameters['member_id'] = $request->user()->id;
//                $parameters['model_id'] = $user->id;
//                $parameters['model_type'] = get_class($user);
//                $this->notificationRepository->sendNotification($user, $body, $title, $parameters);
//            }
            return response()->json(['msg' => trans('dashboard.confirm', ['name' => $fileName]), 'data' => $file], 200);
        }
        return response()->json(['msg' => trans('dashboard.error')], 400);
    }

    public function confirm(Request $request): JsonResponse
    {
        $customer = $this->userRepository->find($request->customer_id, ['fcmTokens']);
        if ($customer) {
            $this->userRepository->update($customer, [
                'is_verified' => true,
            ]);
        }
        if (count($customer->fcmTokens)) {
            $title = 'تم تأكيد بياناتك ';
            $body = "تم تأكيد بياناتك بنجاح ، يمكنك الان حجز الرحلات المفضلة لديك";
            $parameters['type'] = Notification::TYPE_CONFIRM_USER;
            $parameters['member_id'] = $request->user()->id;
            $parameters['model_id'] = $customer->id;
            $parameters['model_type'] = get_class($customer);
            $this->notificationRepository->sendNotification($customer, $body, $title, $parameters);
        }


        $resource = new UserResource($customer);
        return response()->json(['msg' => trans('dashboard.approved'), 'data' => $resource], 200);

    }
}
