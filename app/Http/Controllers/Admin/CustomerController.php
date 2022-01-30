<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\Attachment;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\SQL\AttachmentRepository;
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

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->notificationRepository = app(NotificationRepository::class);
        $this->attachmentRepository = app(AttachmentRepository::class);
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
        return view('dashboard.customers.create');
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
        return view('dashboard.customers.edit', compact('resource'));
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

    public function changeStatusAttachment(Request $request)
    {
        $file = $this->attachmentRepository->find($request->id);

        if ($file) {
            $this->attachmentRepository->update($file, [
                'status' => ($request->status == 'approve') ? Attachment::STATUS_APPROVED : Attachment::STATUS_DISAPPROVED,
                'status_text' => $request->statusText,
            ]);
            return response()->json(['msg' => trans('dashboard.changed_successfully'), 'data' => $file], 200);
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
