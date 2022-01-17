<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\CountryRepository;
use App\Repositories\SQL\GovernorateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GovernorateController extends BaseController
{

    private $governorateRepository;
    private $countryRepository;

    public function __construct( GovernorateRepository $governorateRepository)
    {
        $this->governorateRepository = $governorateRepository;
        $this->countryRepository = app(CountryRepository::class);
//        $this->middleware(['permission:show_governorates'])->only('index');
//        $this->middleware(['permission:create_governorates'])->only(['create', 'store']);
//        $this->middleware(['permission:edit_governorates'])->only(['edit', 'update']);
//        $this->middleware(['permission:delete_governorates'])->only(['destroy']);

    }

    public function index()
    {
        $resources = $this->governorateRepository->search([], [], true, true, false);
        return view('dashboard.governorates.index', compact('resources'));
    }

    public function create()
    {
        $countries = $this->countryRepository->search([], [], true, false, false)->pluck('LName', 'id')->toArray();
        return view('dashboard.governorates.create', compact('countries'));
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
        $countries = $this->countryRepository->search([], [], true, false, false)->pluck('LName', 'id')->toArray();
        $resource = $this->governorateRepository->find($id);
        return view('dashboard.governorates.edit', compact('resource','countries'));
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
