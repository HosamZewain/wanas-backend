<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\ContactUsRepository;
use App\Repositories\SQL\PageRepository;
use Illuminate\Http\JsonResponse;

class ContactUsController extends Controller
{
    private $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }

    public function index()
    {
        $resources = $this->contactUsRepository->search([], [], true, true);
        return view('dashboard.contact_us.index', compact('resources'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->contactUsRepository->find($id);
        $resource->delete();

        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }
}
