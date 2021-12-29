<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\SQL\NotificationRepository;
use App\Repositories\SQL\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{
    private $INotificationRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->INotificationRepository = app(NotificationRepository::class);
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $filters['Type'] = Notification::TYPE_NOTIFY_USERS;
        $resources = $this->INotificationRepository->search($filters, [], true, true);
        return view('dashboard.notifications.index', compact('resources'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $customers_filters['Type'] = User::TYPE_USER;
        $customers = $this->userRepository->search($customers_filters, [], false, false, false);
        $customers = $customers->pluck('name', 'id')->toArray();
        return view('dashboard.notifications.create', compact('customers'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'required_if:receiver,1|array',
            'captain_id' => 'required_if:receiver,2|array',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        if (!empty($request->customer_id)) {
            foreach ($request->customer_id as $key => $value) {
                if (!is_null($value)) {
                    $user = $this->userRepository->find($value);
                    //  $fcm = new SendFCM();
                    //  $msg = $fcm->sendNotification($user, null, $request->body, $request->title, []);
                }

            }
        }
        if (!empty($request->captain_id)) {
            foreach ($request->captain_id as $key => $value) {
                if (!is_null($value)) {
                    $user = $this->userRepository->find($value);
                    //  $fcm = new SendFCM();
                    //  $msg = $fcm->sendNotification($user, null, $request->body, $request->title, []);
                }
            }
        }
        flash(trans('dashboard.sent_successfully'), 'green');
        return redirect()->to(route('notifications.index'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $resource = $this->INotificationRepository->find($id);
        return view('dashboard.notifications.edit', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|unique:companies,name',
        ]);
        $resource = $this->INotificationRepository->find($id);
        $resource->update($request->all());
        flash(trans('dashboard.updated_successfully'), 'green');
        return redirect()->to(route('notifications.index'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $resource = $this->INotificationRepository->find($id);
        $resource->delete();
        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }

    /**
     * Write code on Method
     *
     * @param Request $request
     * @return JsonResponse()
     */
    public function saveToken(Request $request): JsonResponse
    {
        auth()->user()->update(['fcm_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }
}
