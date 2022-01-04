<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\GovernorateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GovernorateController extends BaseController
{

    private $governorateRepository;

    public function __construct( GovernorateRepository $governorateRepository)
    {
        $this->governorateRepository = $governorateRepository;
//        $this->middleware(['permission:show_governorates'])->only('index');
//        $this->middleware(['permission:create_governorates'])->only(['create', 'store']);
//        $this->middleware(['permission:edit_governorates'])->only(['edit', 'update']);
//        $this->middleware(['permission:delete_governorates'])->only(['destroy']);

    }

    public function index()
    {
        $resources = $this->governorateRepository->search([], [], true, true);
        return view('dashboard.governorates.index', compact('resources'));
    }

    public function create()
    {
        return view('dashboard.governorates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);

        $inputs = $request->all();
        $resource = $this->governorateRepository->create($inputs);
        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.created_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }

    public function edit($id)
    {
        $resource = $this->governorateRepository->find($id);
        return view('dashboard.governorates.edit', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);
        $inputs = $request->all();
        $resource = $this->governorateRepository->find($id);
        $resource->update($inputs);

        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.updated_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->governorateRepository->find($id);
        $resource->delete();

        return $this->ResponseJsonSuccess(trans('dashboard.deleted_successfully'), $resource);
    }
}
